<?php 
/*
Plugin Name: Simple Login Calculations checker 
Plugin URI: https://github.com/Amer-Moh 
Description: A simple plugin to add extra number calculations for wp-login form 
Version: 1.0 
Author: Amer Mohammed
Author URI: https://github.com/Amer-Moh 
License: GPLv2 or later 
Text Domain: tutsplus
 
*/


/**
 * Update login form fields to add the calculation fields
 */

function update_login_form_fields() { 
    
    /**
     * Define numbers array ( 1 to 20 )
     */
    $numbers_array = array(
        0 =>"ZERO",
        2 => "TWO",
        4 => "FOUR",
        6 => "SIX",
        8 => "EIGHT",
        10 => "TEN",
        12 => "TWELVE",
        14 => "FOURTEEN",
        16 => "SIXTEEN",
        18 => "EIGHTEEN",
        20 => "TWENTY");

    /** Get random number for the result between 1-20 */
    $result_array_numbers = array(0,2,4,6,8,10,12,14,16,18,20);
    shuffle($result_array_numbers);
    $rand_result = $result_array_numbers[0];

    /** Building the Form */
    ?>    
    <p> <span style="color:red;">Please fill the form</span>
        <label><?php _e('TWO × ') ?><input style="width:20%; display:inline-block;" type="number" name="v_number" id="v_number" class="input" size="1" tabindex="20" /> = <?php echo $numbers_array[$rand_result]; ?> </label>
    </p>
    <input type="hidden" name="rand_result" value="<?php echo $rand_result; ?>">
<?php }
add_action( 'login_form', 'update_login_form_fields' );



/**
 * Validating the answer
 */
function check_login_user_answer( $user ) {
    if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
        // Check if the fields are empty
        if ( empty( $_POST[ 'v_number' ] ) || empty( $_POST[ 'rand_result' ] ) ) {
            $user = new WP_Error( 'emptynumber', '<strong>ERROR</strong>: You did not answer the question.' );
        // Check the answer
        } elseif ( (2*intval($_POST[ 'v_number' ])) !== intval($_POST[ 'rand_result' ]) ) {
            $user = new WP_Error( 'wronganswer', '<strong>ERROR</strong>: You did not answer the question correctly.' );
        }
    }

    return $user;
}
add_filter( 'authenticate', 'check_login_user_answer', 100 );


