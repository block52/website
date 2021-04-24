<?php
namespace crud;

use crud\ElementsUtilities;

class Elements
{
    public $item;
    public $table;
    public $item_display_name;
    public $item_class;
    public $item_class_with_namespace;
    public $fields;
    public $primary_key;
    public $select_data;

    public function __construct($item)
    {
        $json                            = file_get_contents(ADMIN_DIR . 'crud-data/db-data.json');
        $db_data                         = json_decode($json, true);
        $this->item                      = $item;
        $this->table                     = $table = ElementsUtilities::getTableName($item, $db_data);
        $this->item_label                = $db_data[$table]['table_label'];
        $this->item_class                = $db_data[$table]['class_name'];
        $this->item_class_with_namespace = ElementsUtilities::addNameSpace($db_data[$table]['class_name'], 'crud');
        $this->fields                    = $db_data[$table]['fields'];
        $this->primary_key               = $db_data[$table]['primary_key'];

        // select data
        if (file_exists(ADMIN_DIR . 'crud-data/' . $this->item . '-select-data.json')) {
            $json = file_get_contents(ADMIN_DIR . 'crud-data/' . $this->item . '-select-data.json');
            $this->select_data = json_decode($json);
        }
    }
}
