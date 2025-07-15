<?php

namespace App\Http\Controllers;
use App\Models\Jobs;
use Illuminate\Http\Request;

class JobsController extends Controller
{
public function all(){
  return Jobs::all();
}
public function create(Request $request){
  $job = new Job();
  $job->title = $request->title;
  $job->slug = $request->slug;
  $job->delivery_time = $request->delivery_time;
  $job->status = $request->status;
  $job->client_id = $request->client_id;
  $job->description = $request->description;
  $job->tags = $request->tags;
  $job->price = $request->price;
  $job->save();
  
  return 'Good';
}
}
