<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MSudi extends CI_Model
{
    function AddData($tabel, $data=array())
    {
        $this->db->insert($tabel,$data);
        return $this->db->affected_rows();
    }

    function UpdateData($tabel, $where, $where_value, $data=array())
    {
        $this->db->update($tabel, $data, [$where => $where_value]);
        return $this->db->affected_rows();
    }

    function DeleteData($tabel, $where, $where_value)
    {
        $this->db->where($where, $where_value)->delete($tabel);
        return $this->db->affected_rows();
    }

    function GetData($tabel, $where = null, $value = null)
    {
        if($where === null && $value === null)
        {
            $query=$this->db->get($tabel);
            return $query;
        } else {
            $query= $this->db->get_where($tabel, [$where => $value]);
            return $query;
        }

    }

    function check_login($table, $field1, $field2)
    {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where($field1);
        $this->db->where($field2);
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() == 0) {
            return null;
        } else {
            return $query->result();
        }
    }

    function GetDataDesc($tbl1){
        $this->db->select('*');
            $this->db->from($tbl1);
            $this->db->order_by('tanggal', 'desc');
            $query = $this->db->get();
            return $query;
    }

    function GetDataJoinWhere($tbl1, $tbl2, $param, $field, $id){
        $this->db->select('*');
            $this->db->from($tbl1);
            $this->db->join($tbl2, $param);
            $this->db->join ( 't_tahun_ajaran', 't_tahun_ajaran.id_tahun_ajaran = t_jenis_pembayaran.id_tahun_ajaran');
            $this->db->where($field, $id);
            $query = $this->db->get();
            return $query;
    }

    function GetDataJumlahWhere($tbl1, $tbl2, $param, $field, $id){
        $this->db->select('*');
            $this->db->from($tbl1);
            $this->db->join($tbl2, $param);
            $this->db->where($field, $id);
            $this->db->where('id_group_bayar', '1');
            $query = $this->db->get();
            return $query;
    }

    function GetDataJoinDetailBayar($field, $data, $field2, $value) {

        $this->db->select ( '*' ); 
        $this->db->from ( 't_pembayaran');
        $this->db->join ( 't_jenis_pembayaran', 't_pembayaran.id_jenis_pembayaran = t_jenis_pembayaran.id_jenis_pembayaran');
        $this->db->join ( 't_siswa', 't_siswa.nis = t_pembayaran.nis');
        $this->db->join ( 't_rombel', 't_rombel.id_rombel = t_siswa.id_rombel');
        $this->db->join ( 't_tahun_ajaran', 't_tahun_ajaran.id_tahun_ajaran = t_pembayaran.id_tahun_ajaran');
        $this->db->where ($field, $data);
        $this->db->where ($field2, $value);
        $query = $this->db->get();
        return $query;
    }

    function GetDataJoinBayar($field, $data) {

        $this->db->select ( '*' ); 
        $this->db->from ( 't_siswa');
        $this->db->join ( 't_jenis_pembayaran', 't_siswa.id_rombel = t_jenis_pembayaran.id_rombel');
        $this->db->join ( 't_tahun_ajaran', 't_tahun_ajaran.id_tahun_ajaran = t_jenis_pembayaran.id_tahun_ajaran');
        $this->db->where ($field, $data);
        $query = $this->db->get();
        return $query;
    }

    function GetDataJoin($field, $data) {

        $this->db->select ( '*' ); 
        $this->db->from ( 't_pembayaran');
        $this->db->join ( 't_jenis_pembayaran', 't_pembayaran.id_jenis_pembayaran = t_jenis_pembayaran.id_jenis_pembayaran');
        $this->db->join ( 't_siswa', 't_siswa.nis = t_pembayaran.nis');
        $this->db->join ( 't_rombel', 't_rombel.id_rombel = t_siswa.id_rombel');
        $this->db->join ( 't_tahun_ajaran', 't_tahun_ajaran.id_tahun_ajaran = t_pembayaran.id_tahun_ajaran');
        $this->db->where ($field, $data);
        $query = $this->db->get();
        return $query;
    }

    function GetDataJoinJumlah($field, $data, $id) {

        $this->db->select ( 'count(*) as jumlahbayar' ); 
        $this->db->from ( 't_pembayaran');
        $this->db->join ( 't_jenis_pembayaran', 't_pembayaran.id_jenis_pembayaran = t_jenis_pembayaran.id_jenis_pembayaran');
        $this->db->join ( 't_siswa', 't_siswa.nis = t_pembayaran.nis');
        $this->db->join ( 't_rombel', 't_rombel.id_rombel = t_siswa.id_rombel');
        $this->db->where ($field, $data);
        $this->db->where('id_group_bayar', $id);
        $query = $this->db->get();
        return $query;
    }

}