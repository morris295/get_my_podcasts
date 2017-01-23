<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Model\Playlist;



class PlaylistsController extends Controller
{
	
	public function getAll() {
		return view("playlist");
	}
	
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $contents = Input::all();
        
        $data = Playlist::firstOrCreate([
        	"user_id" => $contents["user_id"],
        	"contents" => json_encode($contents["contents"], JSON_UNESCAPED_SLASHES),
        	"playlist_name" => $contents["playlist_name"],
        	"keep_current" => $contents["keep_current"]
        ]);
        
//         $playlist->user_id = $contents["user_id"];
//         $playlist->contents = json_encode($contents["contents"], JSON_UNESCAPED_SLASHES);
//         $playlist->playlist_name = $contents["playlist_name"];
//         $playlist->keep_current = $contents["keep_current"];
        
        response()->json($data, 200, [], JSON_UNESCAPED_SLASHES);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Playlist::where(["user_id" => $id, "keep_current" => 1])->get(["contents"])->toArray();
        return response()->json($data, 200, [], JSON_UNESCAPED_UNICODE);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //TODO: Implement updating a playlist.
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //TODO: Implement deleting a playlist.
    }
}
