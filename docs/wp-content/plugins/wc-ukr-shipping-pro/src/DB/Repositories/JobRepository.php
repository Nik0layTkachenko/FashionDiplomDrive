<?php

namespace kirillbdev\WCUkrShipping\DB\Repositories;

if ( ! defined('ABSPATH')) {
    exit;
}

class JobRepository
{
    private $db;

    public function __construct()
    {
        global $wpdb;

        $this->db = $wpdb;
    }

    public function createJob($name, $data = [])
    {
        $this->db->insert('wc_ukr_shipping_jobs', [
            'name' => $name,
            'status_id' => 0, // Wait status
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ], [
            'name' => '%s',
            'status_id' => '%d',
            'created_at' => '%s',
            'updated_at' => '%s'
        ]);

        foreach ($data as $key => $value) {
            $this->db->insert('wc_ukr_shipping_job_data', [
                'job_id' => $this->db->insert_id,
                'name' => $key,
                'value' => $value
            ], [
                'job_id' => '%d',
                'name' => '%s',
                'value' => '%s'
            ]);
        }
    }

    /**
     * @param string $name
     *
     * @return array
     */
    public function getWaitingJobsByName($name)
    {
        return $this->db->get_results($this->db->prepare("
            SELECT * FROM `wc_ukr_shipping_jobs`
            WHERE `name` = %s AND `status_id` = '0'
        ", $name), ARRAY_A);
    }

    /**
     * @param int $jobId
     *
     * @return array
     */
    public function getJobData($jobId)
    {
        return $this->db->get_results($this->db->prepare("
            SELECT `name`, `value` FROM `wc_ukr_shipping_job_data`
            WHERE `job_id` = %d
        ", $jobId), ARRAY_A);
    }

    /**
     * @param array $ids
     */
    public function removeJobsById($ids)
    {
        $ids = array_map(function ($id) {
            return "'" . (int)$id . "'";
        }, $ids);

        $in = implode(',', $ids);

        $this->db->query("
            DELETE FROM `wc_ukr_shipping_jobs`
            WHERE `id` IN ($in)
        ");

        $this->db->query("
            DELETE FROM `wc_ukr_shipping_job_data`
            WHERE `job_id` IN ($in)
        ");
    }
}