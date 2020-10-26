<?php

namespace App\Http\Controllers;

use App\Models\Gitstar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class GitstarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $gitstars = Gitstar::orderBy('stargazers_count', 'desc')->get();
        return View::make('gitstar', array('gitstars'=>$gitstars, 'keys' => array('id', 'name', 'stargazers_count', 'created_at', 'pushed_at', 'description', 'url')));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Gitstar  $gitstar
     * @return \Illuminate\Http\Response
     */
    public function show($id, Gitstar $gitstar)
    {
      $gitstars = Gitstar::where('id', $id)->get();

      return View::make('gitstar_show', array('gitstars'=>$gitstars, 'keys' => array('id', 'name', 'stargazers_count', 'created_at', 'pushed_at', 'description', 'url')));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Gitstar  $gitstar
     * @return \Illuminate\Http\Response
     */
    public function edit(Gitstar $gitstar)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Gitstar  $gitstar
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Gitstar $gitstar)
    {
      $reference = array('id'=>'id', 'name'=>'name', 'url'=>'url', 'created_at'=>'created_at', 'updated_at'=>'updated_at', 'pushed_at'=>'pushed_at', 'description'=>'description', 'stargazers_count'=>'stargazers_count');
      $api_url =  env('API_URL');
      if (isset($api_url))
      {
        $gitstar->truncate();
        $gitapi = curl_init();

        curl_setopt($gitapi, CURLOPT_URL, $api_url);
        curl_setopt($gitapi, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($gitapi, CURLOPT_HTTPHEADER, array('User-agent: Gitstars'));
        $gitstr = curl_exec($gitapi);
        curl_close($gitapi);
        $gitjs = json_decode($gitstr);
        if (is_object($gitjs))
        {

          foreach ($gitjs->items as $i=>$row)
          {
            //print_r($row);
            $ignore = false;
            $gitstar = new GitStar();
            foreach ($reference as $key1=>$key2)
            {
              if (isset($row->$key2))
              {
                $gitstar->$key1 = $row->$key2;
              }
              else {
                $ignore = true;
              }

            }
            if ($ignore === false)
            {
              $gitstar->save();
            }
            $ignore = false;
          }
          return View::make('gitstar_update', array('gitstars'=>$gitjs, 'ids'=> $i));
        }
      }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Gitstar  $gitstar
     * @return \Illuminate\Http\Response
     */
    public function destroy(Gitstar $gitstar)
    {
        //
    }
}
