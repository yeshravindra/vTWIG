<?php
function create_thumb($directory, $image, $destination) {
  $image_file = $image;
  $image = $directory.$image;

  if (file_exists($image)) {

    $source_size = getimagesize($image);

    if ($source_size !== false) {

      $thumb_width = 100;
      $thumb_height = 100;

      switch($source_size['mime']) {
        case 'image/jpeg':
             $source = imagecreatefromjpeg($image);
        break;
        case 'image/png':
             $source = imagecreatefrompng($image);
        break;
        case 'image/gif':
             $source = imagecreatefromgif($image);
        break;
      }

      $source_aspect = round(($source_size[0] / $source_size[1]), 1);
      $thumb_aspect = round(($thumb_width / $thumb_height), 1);

      if ($source_aspect < $thumb_aspect) {
        $new_size = array($thumb_width, ($thumb_width / $source_size[0]) * $source_size[1]);
        $source_pos = array(0, ($new_size[1] - $thumb_height) / 2);
      } else if ($source_aspect > $thumb_aspect) {
        $new_size = array(($thumb_width / $source_size[1]) * $source_size[0], $thumb_height);
        $source_pos = array(($new_size[0] - $thumb_width) / 2, 0);
      } else {
        $new_size = array($thumb_width, $thumb_height);
        $source_pos = array(0, 0);
      }

      if ($new_size[0] < 1) $new_size[0] = 1;
      if ($new_size[1] < 1) $new_size[1] = 1;

      $thumb = imagecreatetruecolor($thumb_width, $thumb_height);
      imagecopyresampled($thumb, $source, 0, 0, $source_pos[0], $source_pos[1], $new_size[0], $new_size[1], $source_size[0], $source_size[1]);

      switch($source_size['mime']) {
        case 'image/jpeg':
             imagejpeg($thumb, $destination.$image_file);
        break;
        case 'image/png':
              imagepng($thumb, $destination.$image_file);
        break;
        case 'image/gif':
             imagegif($thumb, $destination.$image_file);
        break;
      }


    }

  }
}


function create_thumb_article_image_1($directory, $image, $destination) {
  $image_file = $image;
  $image = $directory.$image;

  if (file_exists($image)) {

    $source_size = getimagesize($image);

    if ($source_size !== false) {

      $thumb_width = 187.5;
      $thumb_height = 150;

      switch($source_size['mime']) {
        case 'image/jpeg':
             $source = imagecreatefromjpeg($image);
        break;
        case 'image/png':
             $source = imagecreatefrompng($image);
        break;
        case 'image/gif':
             $source = imagecreatefromgif($image);
        break;
      }

      $source_aspect = round(($source_size[0] / $source_size[1]), 1);
      $thumb_aspect = round(($thumb_width / $thumb_height), 1);

      if ($source_aspect < $thumb_aspect) {
        $new_size = array($thumb_width, ($thumb_width / $source_size[0]) * $source_size[1]);
        $source_pos = array(0, ($new_size[1] - $thumb_height) / 2);
      } else if ($source_aspect > $thumb_aspect) {
        $new_size = array(($thumb_width / $source_size[1]) * $source_size[0], $thumb_height);
        $source_pos = array(($new_size[0] - $thumb_width) / 2, 0);
      } else {
        $new_size = array($thumb_width, $thumb_height);
        $source_pos = array(0, 0);
      }

      if ($new_size[0] < 1) $new_size[0] = 1;
      if ($new_size[1] < 1) $new_size[1] = 1;

      $thumb = imagecreatetruecolor($thumb_width, $thumb_height);
      imagecopyresampled($thumb, $source, 0, 0, $source_pos[0], $source_pos[1], $new_size[0], $new_size[1], $source_size[0], $source_size[1]);

      switch($source_size['mime']) {
        case 'image/jpeg':
             imagejpeg($thumb, $destination.$image_file);
        break;
        case 'image/png':
              imagepng($thumb, $destination.$image_file);
        break;
        case 'image/gif':
             imagegif($thumb, $destination.$image_file);
        break;
      }


    }

  }
}
?>