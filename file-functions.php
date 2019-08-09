<?php
$allow_show_folders = true; // Set to false to hide all subdirectories
$hidden_extensions = ['php']; // must be an array of lowercase file extensions. Extensions hidden in directory index
function is_entry_ignored($entry, $allow_show_folders, $hidden_extensions) {
  if ($entry === basename(__FILE__)) {
    return true;
  }
  if (is_dir($entry) && !$allow_show_folders) {
    return true;
  }
  $ext = strtolower(pathinfo($entry, PATHINFO_EXTENSION));
  if (in_array($ext, $hidden_extensions)) {
    return true;
  }
  return false;
}