<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class ProductModel extends Model
{
    protected $table = 'products';

    public function getAll()
    {
        return $this->db->table($this->table)->get_all();
    }

    public function getById($id)
    {
        return $this->db->table($this->table)->where('id', $id)->get();
    }

    public function create($data)
    {
        return $this->db->table($this->table)->insert($data);
    }

    public function updateProduct($id, $data)
    {
        $affected = $this->db->table($this->table)->where('id', $id)->update($data);

        if ($affected > 0) {
            return true;
        }

        /*
         * The driver reports 0 changed rows when every submitted value
         * already matches the stored one. That is a successful, idempotent
         * update, not a failure, so confirm the row really exists before
         * telling the caller that nothing was updated.
         */
        return (bool) $this->db->table($this->table)->where('id', $id)->get();
    }

    public function deleteProduct($id)
    {
        return $this->db->table($this->table)->where('id', $id)->delete();
    }
}
//Ang Model ang kumakatawan sa data/database ng application.