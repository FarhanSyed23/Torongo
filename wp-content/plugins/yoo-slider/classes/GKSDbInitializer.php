<?php

class GKSDbInitializer {
    public $tableSliders;
    public $tableSlides;
    public $tableOptions;

function __construct(){
    $this->tableSliders = GKS_TABLE_SLIDERS;
    $this->tableSlides = GKS_TABLE_SLIDES;
    $this->tableOptions = GKS_TABLE_OPTIONS;
}

public function configure(){
    //NOTE: before any configuration check what should we do later. Should we initialize with demo data or not, or something else.
    $needsConfiguration = $this->needsConfiguration();
//    $needInitialization = $this->needsInitialization();

    if($needsConfiguration){
        $this->setupTables();
    }

//    if($needInitialization){
        //$this->initializeTables();
//    }
}

public function needsConfiguration(){
    global $wpdb;

    $sql = "SHOW TABLES FROM `{$wpdb->dbname}`  WHERE";
    $sql .=" `Tables_in_{$wpdb->dbname}` LIKE '%{$this->tableSliders}%' OR";
    $sql .=" `Tables_in_{$wpdb->dbname}` LIKE '%{$this->tableSlides}%' OR";;

    $res = $wpdb->get_results($sql,ARRAY_A);

    //If any table is missing needs setup
    return count($res) < 4;
}

public function needsInitialization(){
    global $wpdb;

    $sql = "SHOW TABLES FROM `{$wpdb->dbname}`  WHERE";
    $sql .=" `Tables_in_{$wpdb->dbname}` LIKE '%{$this->tableSliders}%' OR";
    $sql .=" `Tables_in_{$wpdb->dbname}` LIKE '%{$this->tableSlides}%'";

    $res = $wpdb->get_results($sql,ARRAY_A);

    //If there is no tables yet, needs initialization
    return count($res) == 0;
}

public function checkForChanges() {
    global $wpdb;
    $table = $wpdb->get_results( $wpdb->prepare(
        "SELECT COUNT(1) FROM information_schema.tables WHERE table_schema=%s AND table_name=%s;",
        $wpdb->dbname, $this->tableSlides
    ) );
    if ( !empty( $table ) ) {
        $column = $wpdb->get_results($wpdb->prepare(
            "SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = %s AND TABLE_NAME = %s AND COLUMN_NAME = %s ",
            $wpdb->dbname, $this->tableSlides, 'details'
        ));
        if (empty($column)) {
            $sql = "ALTER TABLE `{$this->tableSlides}` ADD `details` text";
            $wpdb->query($sql);
        }
    }
    $table = $wpdb->get_results( $wpdb->prepare(
        "SELECT COUNT(1) FROM information_schema.tables WHERE table_schema=%s AND table_name=%s;",
        $wpdb->dbname, $this->tableSliders
    ) );
    if ( !empty( $table ) ) {
        $column = $wpdb->get_results($wpdb->prepare(
            "SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = %s AND TABLE_NAME = %s AND COLUMN_NAME = %s ",
            $wpdb->dbname, $this->tableSliders, 'css'
        ));
        if (empty($column)) {
            $sql = "ALTER TABLE `{$this->tableSliders}` ADD `css` text";
            $wpdb->query($sql);
        }
    }
}

private function setupTables(){
    global $wpdb;

    $charset_collate = '';

    if ( ! empty( $wpdb->charset ) ) {
        $charset_collate = "DEFAULT CHARACTER SET {$wpdb->charset}";
    }

    if ( ! empty( $wpdb->collate ) ) {
        $charset_collate .= " COLLATE {$wpdb->collate}";
    }

    $table = $wpdb->get_results( $wpdb->prepare(
        "SELECT COUNT(1) FROM information_schema.tables WHERE table_schema=%s AND table_name=%s;",
        $wpdb->dbname, $this->tableSlides
    ) );
    $firstTime = empty( $table );

    //Create Sliders table
    $sql = "CREATE TABLE IF NOT EXISTS {$this->tableSliders} (
                  `id` int NOT NULL AUTO_INCREMENT,
                  `title` varchar(255) DEFAULT NULL,
                  `corder` text DEFAULT '',
                  `options` text DEFAULT '',
                  `extoptions` text DEFAULT '',
                  PRIMARY KEY (`id`)
                )ENGINE=InnoDB $charset_collate;
        ";
    $wpdb->query( $sql );

    //Create Slides table
    $sql = "CREATE TABLE IF NOT EXISTS {$this->tableSlides} (
                  `id` int NOT NULL AUTO_INCREMENT,
                  `sid` int NOT NULL,
                  `title` varchar(255) DEFAULT NULL,
                  `description` text DEFAULT '',
                  `url` text DEFAULT '',
                  `cover` text DEFAULT '',
                  `pics` text DEFAULT '',
                  `categories` text DEFAULT '',
                  `cdate` datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
                  PRIMARY KEY (`id`)
                )ENGINE=InnoDB $charset_collate;
        ";
    $wpdb->query( $sql );

    if ($firstTime) {
        //Add cascade FK. Relation between ( slide & slider )

        $sql = "ALTER TABLE `{$this->tableSlides}` ADD INDEX `sid_index` (`sid`)";
        $wpdb->query($sql);

        $sql = "ALTER TABLE `{$this->tableSlides}` ADD CONSTRAINT `gks_sid_fk` FOREIGN KEY (`sid`) REFERENCES `{$this->tableSliders}` (`id`) ON DELETE CASCADE ON UPDATE CASCADE";
        $wpdb->query($sql);
    }
}

private function initializeTables(){
    global $wpdb;

    //Insert demo slider
    $wpdb->insert(
        $this->tableSliders,
        array(
            'title' => 'New slider',
            'corder' => '1,2,3',
            'options' => GKSHelper::getDefaultOptions()
        )
    );
    $sid = $wpdb->insert_id;

    //Add demo slide
    $wpdb->insert(
        $this->tableSlides,
        array(
            'sid' => $sid,
            'title' => 'Slide 1',
            'description' => "Slide description 1",
        )
    );

    $wpdb->insert(
        $this->tableSlides,
        array(
            'sid' => $sid,
            'title' => 'Slide 2',
            'description' => "Slide description 2",
        )
    );

    $wpdb->insert(
        $this->tableSlides,
        array(
            'sid' => $sid,
            'title' => 'Slide 3',
            'description' => "Slide description 3",
        )
    );
}

}
