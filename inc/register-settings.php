
<?php // no closing bracket menas that the entire thing is php 

// this page is where that whole customize tab in the word pres admin takes place 

// nav bar function 
function register_primary_menu() {
  register_nav_menu( 'primary', 'Primary Menu' );
}
add_action( 'after_setup_theme', 'register_primary_menu' );

/*
*
* Walker for the main menu 
*
*/
function add_arrow( $output, $item, $depth, $args ){
  //Only add class to 'top level' items on the 'primary' menu.
  if('primary' == $args->theme_location && $depth === 0 ){
      if (in_array("menu-item-has-children", $item->classes)) {
          $new_output = '<div class="sub-wrap">' . 
                          $output . 
                        '<i class="nav-icon fas fa-chevron-down down-icon" aria-hidden="true"></i></div>';
          return $new_output;
      }
  }
  return $output;
}
add_filter( 'walker_nav_menu_start_el', 'add_arrow',10,4);

// Example of how to use a repeatable box

function example_repeatable_customizer($wp_customize) {
  require 'section_vars.php';  
  require_once 'controller.php';  
  
  $wp_customize->add_section($example_section, array(
    'title' => 'Example Repeaters',
  ));
  
  $wp_customize->add_setting(
    $example_repeater,
    array(
        'sanitize_callback' => 'onepress_sanitize_repeatable_data_field',
        'transport' => 'refresh',
    ) );

  $wp_customize->add_control(
      new Onepress_Customize_Repeatable_Control(
          $wp_customize,
          $example_repeater,
          array(
              'label' 		=> esc_html__('Example Q & A Repeater'),
              'description'   => '',
              'section'       => $example_section,
              'live_title_id' => 'some_quote',
              'title_format'  => esc_html__('[live_title]'), // [live_title]
              'max_item'      => 10, // Maximum item can add
              'limited_msg' 	=> wp_kses_post( __( 'Max items added' ) ),
              'fields'    => array(
                  'some_quote'  => array(
                      'title' => esc_html__('Text'),
                      'type'  =>'text',
                  ),
                  'some_image' => array(
                    'title' => esc_html__('Image'),
                    'type'  =>'media',
                ),
              ),
          )
      )
  );
}
add_action( 'customize_register', 'example_repeatable_customizer' );

// THERE IS A FUNC HERE CALLED HOME_CUSTOMIZER 
function home_customizer($wp_customize) {
  require 'section_vars.php'; // this of this like an import statement. ur importing a file with function and var definitions 
  // you don't have to do the above line, but you could 
  // it inclues the home_section variables, so that code below will work 
  $wp_customize->add_section($home_section, array( // add_seciton is sort of like a member function of wp_customize, and we pass it some variables 
    // 
    'title' => 'Testing Home Page',
  ));
  // the code above is clearly responsible for the testing home page tab in the customize tab 

  // corresponds to the video 
  $wp_customize->add_setting($home_top_vid, array(
    'default' => 'https://www.youtube.com/embed/A0Wyx-OOX4A',
    'sanitize_callback' => 'sanitize_text_field',
  ));

  $wp_customize->add_control($home_top_vid, array(
    'label' => 'Top Video Embed',
    'section' => $home_section,
  ));

  // corresponds to the image 
  $wp_customize->add_setting($home_top_img);
  $wp_customize->add_control( new WP_Customize_Image_Control( 
      $wp_customize, 
      $home_top_img, 
      array(
          'label' => 'Top Image',
          'section' => $home_section
      )
  ));
  // Top Desc
  // corresponds to the text 
  $wp_customize->add_setting($home_top_desc);
  $wp_customize->add_control($home_top_desc, array(
      'label' => 'Top Description',
      'section' => $home_section,
      'type' => 'textarea'
  ));
}
// Essentially we want to copy this function here to create our own function that does smth similar 
add_action( 'customize_register', 'home_customizer' ); // this is an action hook. you are saying, when you do the action, the first parameter which is customize_register here, you want to run the functio that is the second parameter 
// customize_register is another built in word press name for when you click on the customize tab
// essentially, this line is like: when you clidk on the customize lab, you wna tot run the home_customizer program 
// second parameter is specific to the name of our function 
// the first parameter is always the built in object 'customize_register' though 
// add this line right after the name of your function 

// in php you want a dollar sign in front of variables 

function portfolio_projects_customizer($wp_customize) {// here you pass in a variable called wp_customize. this is a built in word press object that represents the whole customize tab in wordpress admin. we need it in order to modify the page {
  require 'section_vars.php';
  $wp_customize->add_section($project_section, array (
      'title' => 'Projects'
  )); // if you do this then make sure you also go into section_vars and add a variable called project_section {
    // if you use a variable, then remember to update the section_vars.php file. if you don't use a variable then you can directly pass in the string "project_section" 
    // the variable you pass in bascially gives the section you added a name 
    // second argument is always an array 
    // then you add different elements to your array - the most important thing is that you have a title so that clients will know which tab to click on 
    // title is an expected argument that wordpress wants to see 
    // need a ; at the end of the wp_customize thing 
}
add_action('customize_register', 'portfolio_projects_customizer');

