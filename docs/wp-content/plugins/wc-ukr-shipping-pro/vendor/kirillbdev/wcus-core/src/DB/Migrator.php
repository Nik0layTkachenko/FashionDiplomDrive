<?php

namespace kirillbdev\WCUSCore\DB;

if ( ! defined('ABSPATH')) {
    exit;
}

class Migrator
{
    private static $OPTION_HISTORY = 'wcus_migrations_history';

    private $db;

    /**
     * @var Migration[]
     */
    private $migrations = [];

    /**
     * @var array
     */
    private $history = [];

    /**
     * @var int
     */
    private $works = 0;

    public function __construct()
    {
        global $wpdb;

        $this->db = $wpdb;
        $this->collate = $wpdb->get_charset_collate();
        $history = get_option(self::$OPTION_HISTORY);

        if ($history) {
            $this->history = json_decode($history, true);
        }
        else {
            $this->history = [];
        }
    }

    public function __get($name)
    {
        return $this->$name;
    }

    /**
     * @param Migration $migration
     */
    public function addMigration($migration)
    {
        if ( ! isset($this->migrations[ $migration->name() ])) {
            $this->migrations[ $migration->name() ] = $migration;
        }
    }

    /**
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->migrations as $migration) {
            if ( ! in_array($migration->name(), $this->history)) {
                $migration->up($this->db);
                $this->history[] = $migration->name();
                $this->works++;
            }
        }

        if ($this->works) {
            update_option(self::$OPTION_HISTORY, json_encode($this->history));
        }
    }
}