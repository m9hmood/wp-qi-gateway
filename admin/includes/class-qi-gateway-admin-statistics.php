<?php
/**
 *
 * define the hooks and settings for admin page
 *
 * @package    Qi_Gateway
 * @subpackage Qi_Gateway/admin
 * @author     Mahmood Abbas <contact@mahmoodshakir.com>
 * @since      1.0.0
 */
class QI_GATEWAY_ADMIN_STATISTICS
{
    protected  $db_name;
    protected  $db;

    public function __construct()
    {
        global $wpdb;
        $this->db_name = $wpdb->base_prefix . 'qi_logs';
        $this->db = $wpdb;
    }

    public function get_total_paid_orders()
    {
        $sql = "SELECT SUM(amount) FROM $this->db_name WHERE status='%s' AND operation='%s'";
        return number_format($this->db->get_var($this->db->prepare($sql, array(QiOperationStatus::SUCCESS, QiCustomerOperations::PAYMENT) )) ?? 0);
    }

    public function get_total_unpaid_orders()
    {
        $sql = "SELECT COUNT(*) FROM $this->db_name WHERE status='%s' AND operation='%s'";
        return number_format($this->db->get_var($this->db->prepare($sql, array(QiOperationStatus::FAIL, QiCustomerOperations::PAYMENT) )) ?? 0);
    }

    public function get_total_orders()
    {
        $sql = "SELECT COUNT(*) FROM $this->db_name WHERE status='%s' AND operation='%s'";
        return number_format($this->db->get_var($this->db->prepare($sql, array(QiOperationStatus::SUCCESS, QiCustomerOperations::CREATE) )) ?? 0);
    }
}