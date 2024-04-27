<?php
class DB extends CI_Model
{
    public function loader($page, $data)
    {
        $this->load->view('Load/topside', $data);
        $this->load->view($page, $data);
        $this->load->view('Load/bottom', $data);
    }
    public function fetch($table)
    {
        return $this->db->get($table);
    }
    public function fetchWhere($where, $table)
    {
        return $this->db->get_where($table, $where);
    }
    public function insert($data, $table)
    {
        $this->db->insert($table, $data);
    }
    public function update($where, $data, $table)
    {
        $this->db->update($table, $data, $where);
    }
    public function delete($where, $table)
    {
        $this->db->delete($table, $where);
    }
    public function fetchTwoJoin($tblJoinA, $tblJoinB, $joinA, $joinB, $table)
    {
        return $this->db->select('*')
            ->from($table)
            ->join($tblJoinA, $joinA)
            ->join($tblJoinB, $joinB)
            ->get();
    }
    public function fetchJoin($tblJoin, $join, $table)
    {
        return $this->db->select('*')
            ->from($table)
            ->join($tblJoin, $join)
            ->get();
    }
    public function fetchJoinWhere($where, $tblJoin, $join, $table)
    {
        return $this->db->select('*')
            ->from($table)
            ->where($where)
            ->join($tblJoin, $join)
            ->get();
    }
    public function hitungDiskon($nom)
    {
        return $this->db->query("SELECT * FROM diskon WHERE minimal <= '$nom' ORDER BY minimal DESC limit 1");
    }
    public function getStok($awal, $akhir, $table)
    {
        return $this->db->query("SELECT * FROM $table WHERE pada >= '$awal' AND pada <= '$akhir'");
    }
    public function getStokJoin($tblJoin, $join, $awal, $akhir, $table)
    {
        return $this->db->select('*')
            ->from($table)
            ->where("waktu >= '$awal'")
            ->where("waktu <= '$akhir'")
            ->join($tblJoin, $join)
            ->get();
    }
    public function getTransaksi($awal, $akhir, $table)
    {
        return $this->db->select('*')
        ->from($table)
        ->where("tanggal_penjualan >= '$awal'")
        ->where("tanggal_penjualan <= '$akhir'")
        ->where("id_petugas != 0")
        ->get();
    }
}
