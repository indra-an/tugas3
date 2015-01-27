<?php

class PhotoController extends \BaseController {
	var $path ;
	var $path_img ;
	
	public function __construct()
	{
		$this->path_img = 'upload_gambar';
		$this->path = public_path() . '/upload_gambar';
		
    } 
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$photo = Photo::all();
		return View::make('img.list')
		->with('photo', $photo)
		->with('path', $this->path_img)
		;
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('img.upload');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
	$validate = Validator::make(Input::all(), Photo::valid());
    if($validate->fails()) {
      return Redirect::to('img/create')
        ->withErrors($validate);
    }
	
    if (Input::hasFile('file'))
    {
      $file_name = Input::file('file')->getClientOriginalName();
      $new_data = new Photo;
      $new_data->file = $file_name;
      $new_data->title = Input::get('title');
      $new_data->save();

      $path_save_image = $this->path.'/'.$new_data->id;
      if(!File::exists($path_save_image)) {
        File::makeDirectory($path_save_image, $mode = 0777, true, true);
      }
      $file = Input::file('file');
      Image::make($file)->resize(200, 100)->save($path_save_image.'/thumb-'.$file_name);
      Image::make($file)->resize(600, 300)->save($path_save_image.'/'.$file_name);
      //after move temporary image will disappear
    //  Input::file('file')->move($path_save_image, $file_name);

      Session::flash('notice', 'Image Success Add to Gallery');
      return Redirect::to('/');
    } else {
      Session::flash('error', 'Image not exist');
      return Redirect::to('img/create');
    }
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
	$photo = Photo::find($id);
    return View::make('img.show')
      ->with('photo', $photo)
	  ->with('path', $this->path_img);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$photo = Photo::find($id);
		return View::make('img.edit')
			->with('photo', $photo);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
	$validate = Validator::make(Input::all(),Photo::valid());
	if($validate->fails()) {
      return Redirect::to('img/edit')
        ->withErrors($validate);
    }
    if (Input::hasFile('file'))
    {
      $file_name = Input::file('file')->getClientOriginalName();
      $new_data = Photo::find($id);
      $new_data->file = $file_name;
      $new_data->title = Input::get('title');
      $new_data->save();

      $path_save_image = $this->path.'/'.$new_data->id;
      File::cleanDirectory($path_save_image);
      
	  $file = Input::file('file');
      Image::make($file)->resize(200, 100)->save($path_save_image.'/thumb-'.$file_name);
      Image::make($file)->resize(600, 300)->save($path_save_image.'/'.$file_name);
      //after move temporary image will disappear
    //  Input::file('file')->move($path_save_image, $file_name);

      Session::flash('notice', 'Image Updated');
      return Redirect::to('/');
    } else {
      $new_data = Photo::find($id);
      $new_data->title = Input::get('title');
      $new_data->save();
	  
	  Session::flash('notice', 'Title Updated');
      return Redirect::to('/');
    }
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$photo = Photo::find($id);
		$photo->delete();
		
		$path_img = $this->path.'/'.$id;
		File::deleteDirectory($path_img);
		
		Session::flash('notice', 'Image success deleted');
		return Redirect::to('/');
	}


}
