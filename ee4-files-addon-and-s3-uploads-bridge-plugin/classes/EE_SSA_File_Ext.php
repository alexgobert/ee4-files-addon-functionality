<?php

require_once __DIR__ . '/../../files-addon-for-event-espresso-4/EE_SSA_FILE.php';
require_once __DIR__ . "/EE_File_Validation_Strategy_Ext.php";

class EE_SSA_FILE_Ext extends EE_SSA_FILE {
    function __construct($options = array()) {
        parent::__construct($options);

        $this->removeAllValidationStrategies();

        $this->add_validation_strategy(new EE_FILE_Validation_Strategy_Ext());
    }
}