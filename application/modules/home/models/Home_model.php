<?php
    /**
     * Home Model
     */
    if (!defined('BASEPATH')) exit('No direct script access allowed');

    /**
     * Home class
     *
     * Model for Home
     *
     * @access public
     */
    class Home_model extends CI_Model {
        /** @var string $table users */
        public $table = 'products';
        /** @var string $id Primary Key is id */
        public $id = 'id';
        /** @var string $order Primary Order is DESC */
        public $order = 'DESC';
        /**
         * Home_model construct
         */
        function __construct() {
            parent::__construct();
        }

        /**
         * GET_ALL
         *
         * Get all records of users
         *
         * @param
         * @return object
         */
        function get_all_products() {
            $this->db->order_by($this->id, $this->order);
            return $this->db->get($this->table)->result();
        }

        /**
         * get_product_infos
         * 
         * Get all product information values
         */
        function get_product_infos() {
            $this->db->select('value');
            $this->db->from('informations2');
            $this->db->order_by("product_id", "desc");
            $this->db->order_by("col", "asc");
            return $this->db->get()->result();
        }

        /**
         * GET_SUM_OF_COL
         *
         * Get summation of values of product id according to columns
         *
         * @param
         * @return object
         */
        function get_sum_of_col($product_id = NULL,$col = 0) {
            $this->db->select_sum('value');
            $this->db->from('informations2');
            if($col % 3 === 0)
                $this->db->where("product_id = $product_id AND mod(col, 3) = 0");
            elseif($col % 3 === 1)
                $this->db->where("product_id = $product_id AND mod(col, 3) = 1");
            else
                $this->db->where("product_id = $product_id AND mod(col, 3) = 2");
            // $query = $this->db->get()->row_array();
            // print_r($this->db->last_query());
            // die();
            return $this->db->get()->row()->value;
        }

        /**
         * GET_HEADINGS
         */
        function get_headings() {
            return $this->db->get('headings')->result();
        }

        /**
         * GET_SUBHEADINGS
         */
        function get_subheadings() {
            return $this->db->get('subheadings')->result();
        }

        /**
         * GET_BY_ID
         *
         * Get all records by $id of users
         *
         * @param $id
         * @return object
         */
        function get_by_id($id) {
            $this->db->where($this->id, $id);
            return $this->db->get($this->table)->row();
        }

        /**
         * INSERT_DATA
         *
         * Insert data @ users
         *
         * @param $data
         * @return void
         */
        function insert($data) {
            $this->db->insert($this->table, $data);
            return $this->db->insert_id();
        }

        function insert_info($data) {
            $this->db->insert_batch('informations2', $data);
            return $this->db->insert_id();
        }

        function insert_heading($data) {
            $this->db->insert('headings', $data);
            return $this->db->insert_id();
        }

        /**
         * UPDATE_DATA
         *
         * Update value @ informations2 by $product_id & $col
         *
         * @param $product_id
         * @param $col
         * @param $data
         * @return $col
         */
        function update($product_id = NULL, $col = NULL, $data) {
            $this->db->trans_start();
            
            $this->db->where(array('product_id' => $product_id, 'col' => $col));
            $this->db->update('informations2', $data);
            
            $this->db->trans_complete();
            
            if ($this->db->trans_status() === FALSE) {
                return 'transaction_error';
            }
            else return $col;
        }

        /**
         * RESET
         * 
         * Resets row in one click
         */
        function reset($product_id = NULL) {
            $this->db->trans_start();

            $this->db->set('value', 0);
            $this->db->where(array('product_id' => $product_id));
            $this->db->update('informations2');

            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE) {
                return 'transaction_error';
            }
            else return $product_id;
        }

        /**
         * DELETE_PRODUCT
         *
         * DELETE product @ products by $id
         *
         * @param $id
         * @return void
         */
        function delete_product($id) {
            $this->db->trans_start();
            
            $this->db->where($this->id, $id);
            $this->db->delete($this->table);
            
            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE) {
                return 'transaction_error';
            }
            else return $id;
        }

        /**
         * SHRINK_HEADING
         *
         * Reduce heading @ headings by $id
         *
         * @param $id
         * @return void
         */
        function shrink_heading($id) {
            $this->db->trans_start();
            
            $this->db->set('id', 'id-1', FALSE);
            $this->db->where('id >', $id);
            $this->db->update('headings');
            
            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE) {
                return 'transaction_error';
            }
            else return $id;
        }

        /**
         * SHRINK_COLUMNS
         *
         * Reduce columns @ informations2 by $col
         *
         * @param $id
         * @return void
         */
        function shrink_info($col) {
            $this->db->trans_start();
            
            $this->db->set('col', 'col-3', FALSE);
            $this->db->where('col >', $col);
            $this->db->update('informations2');
            
            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE) {
                return 'transaction_error';
            }
            else return $col;
        }
        /**
         * DELETE_PRODUCT
         *
         * DELETE product @ products by $id
         *
         * @param $id
         * @return void
         */
        function delete_heading($id) {
            $this->db->trans_start();
            
            $this->db->where($this->id, $id);
            $this->db->delete('headings');
            
            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE) {
                return 'transaction_error';
            }
            else return $id;
        }

        /**
         * DELETE_INFO
         *
         * DELETE info @ products by column
         *
         * @param $id
         * @return void
         */
        function delete_info($col) {
            $this->db->trans_start();
            
            $this->db->where('col', $col);
            $this->db->delete('informations2');
            
            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE) {
                return 'transaction_error';
            }
            else return $col;
        }

        /**
         * JSON
         *
         * Get json fromat of products
         *
         * @param
         * @return JSON output
         */
        function json() {
            return json_encode($this->db->get($this->table)->result());
        }
    }

    /* End of file Home_model.php */
