<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 * @package	Freelancer Office
 * @author	William M
 */
class Role_model extends CI_Model
{
	
	function roles()
	{
		$query = $this->db->get('roles');
		if ($query->num_rows() > 0){
			return $query->result();
		} 
	}
	function create_role($data)
	{
		if ($this->db->insert('fx_roles', $data)) {
			$user_id = $this->db->insert_id();
			return array('user_id' => $user_id);
		}
		return NULL;
	}
	function update_role($data,$role_id)
	{
                $where = array(
                    'r_id' => $role_id
                );
                $this->db->where($where);
                if ($this->db->update('fx_roles', $data)) {
		}
		return NULL;
	}
	function delete_role($role_id)
	{
                $where = array(
                    'r_id' => $role_id
                );
                $this->db->where($where);
                if ($this->db->delete('fx_roles')) {
		}
		return NULL;
	}
	function role_details($role_id)
	{
            return $this->db->where('r_id',$role_id)->get('fx_roles')->result();
	}
	
}

/* End of file model.php */