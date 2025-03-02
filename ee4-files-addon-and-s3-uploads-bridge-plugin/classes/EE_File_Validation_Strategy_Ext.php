<?php

require_once __DIR__ . '/../../files-addon-for-event-espresso-4/EE_FILE_Validation_Strategy.php';

class EE_FILE_Validation_Strategy_Ext extends EE_FILE_Validation_Strategy {
    public function validate($normalized_value) {
        if ($normalized_value == '') {
            return true;
        }
        
        global $wpdb;
        $qid = $this->_input->name();
        
        $table = $wpdb->prefix . 'esp_question_allowed_ext';
      
        $ext = $wpdb->get_var("SELECT ext FROM $table WHERE qst_id='$qid'");
        $ex = ($ext != '')? explode(',',$ext) : '';

        $filetype = wp_check_filetype($normalized_value);
        $data = parse_url($normalized_value);
        
        $host = $data['host'];

        // use s3-uploads url if defined, otherwise use default host
        $server = (defined('S3_UPLOADS_BUCKET_URL')) ? str_replace('https://', '', S3_UPLOADS_BUCKET_URL) : $_SERVER['SERVER_NAME'];

        $allowed = ($ex != '') ? $ex : array('gif','png' ,'jpg','jpeg','bmp');
        
        $extn =  $filetype['ext'];
        if (!in_array($extn, $allowed) || strpos($host, $server) === FALSE) {
            throw new EE_Validation_Error($this->get_validation_error_message(), 'regex');
        }

        // validating with grandparent. cannot validate with parent because we need to overwrite the functionality of the parent class to be compatible with s3-uploads
        // from https://stackoverflow.com/a/8212262
        EE_Validation_Strategy_Base::validate($normalized_value);
        
    }
}