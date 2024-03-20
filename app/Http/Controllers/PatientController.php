<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Patient;
use App\Models\Media;
use Illuminate\Support\Facades\Hash;
use OpenApi\Annotations as OA;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Arr;



class PatientController extends Controller
{


    public function addPatient(Request $request)
    {
            // Validate the incoming request data
            $validatedData = $request->validate([
                'fname' => 'required|string',
                'lname' => 'required|string',
                'mname' => 'required|string',
                'dob' => 'required|date_format:Y-m-d',
                'street' => 'required|string',
                'date' => 'required|date_format:Y-m-d',
                'sex' => 'required|string|in:Male,Female,Other',
                'provider_id' => 'required|integer',
                'external_id' => 'required|integer',
            ]);
        
            $patient = Patient::insertPatient($validatedData);

            return response()->json(['message' => 'Patient created successfully', 'patient' => $patient], 201);
        }

    
        public function sendAudio(Request $request)
        {
            $validatedData = $request->validate([
                'audioPath' => 'required|unique:media,audioPath', // Ensure audioPath is unique
                'created_by' => 'required|string',
                'visit_id' => 'required',
                'pid' => 'required',
            ]);

            $audioPath = $request->file('audioPath')->store('public/audio');
            $existingMedia = Media::where('visit_id', $validatedData['visit_id'])->first();
            if ($existingMedia) {
                $existingMedia->audioPath = $audioPath; // Update audioPath with the new value
                $existingMedia->created_by = $validatedData['created_by']; // Update created_by
                $existingMedia->save();
                $message = 'Media record updated successfully';
            } else {
                $media = Media::create([
                    'visit_id' => $validatedData['visit_id'],
                    'pid' => $validatedData['pid'],
                    'audioPath' => $audioPath,
                    'created_by' => $validatedData['created_by']
                ]);
                $message = 'Media record created successfully';
            }
            return response()->json(['message' => $message], 201);
        }



        public function getListAudio(Request $request){

        }

}