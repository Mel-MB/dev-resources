<?php
  /*
   * Base Controller
   * Loads the models and views
   */
namespace Project\Controllers;

  class Controller {
    // Load view
    public function view($view, $data = []){
      // Check for view file
      if(file_exists('app/views/' . $view . '.php')){
        require_once 'app/views/front/templates/header.php';
        require_once 'app/views/' . $view . '.php';
        require_once 'app/views/front/templates/footer.php';
      } else {
        // View does not exist
        die("Cette page n'existe pas");
      }
    }
  }