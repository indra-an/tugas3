<?php

class Photo extends \Eloquent {
	protected $table = 'photo';
  	protected $guarded = array('id');
  	protected $fillable = array('title', 'file');

	public static function valid() {

      return array(
		'title' => 'required',
		'file' => 'mimes:jpeg,bmp,png|max:2000 * 1024'
      );

    }
}