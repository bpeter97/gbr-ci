<?php

if ( ! defined('BASEPATH') ) exit('No direct script access allowed');

class User extends CI_Model
{
    private $id,
            $username,
            $password,
            $first_name,
            $last_name,
            $phone,
            $title,
            $type;

    public function get_id() { return $this->id; }
    public function get_username() { return $this->username; }
    public function get_password() { return $this->password; }
    public function get_first_name() { return $this->first_name; }
    public function get_last_name() { return $this->last_name; }
    public function get_phone() { return $this->phone; }
    public function get_title() { return $this->title; }
    public function get_type() { return $this->type; }

    public function set_id($id) { $this->id = $id; return $this; }
    public function set_username($name) { $this->username = $name; return $this; }
    public function set_password($pass) { $this->password = $pass; return $this; }
    public function set_first_name($name) { $this->first_name = $name; return $this; }
    public function set_last_name($name) { $this->last_name = $name; return $this; }
    public function set_phone($phone) { $this->phone = $phone; return $this; }
    public function set_title($title) { $this->title = $title; return $this; }
    public function set_type($type) { $this->type = $type; return $this; }

    public function __construct($id = NULL)
    {
        parent::__construct();
        
        if( ! $id === NULL )
        {
            $this->set_user_data($id);
        }
    }

    // previously getUserInfo($id = null)
    public function get_user_info($id = NULL)
    {
        if( ! $id === NULL )
        {
            // Return user info based on supplied ID.
            return $this->db->get_where('users', ['id' => $id])->result();
        }
        else
        {
            // Return user info based on user model ID.
            return $this->db->get_where('users', ['id' => $this->get_id()])->result();
        }
    }

    public function set_user_data($id)
    {
        if(is_int($id))
        {
            $user = $this->get_user_info($id);
        }
        else
        {
            $user = $id;
        }

        // Use setters to setup this objects properties using the object passed in.
        if(is_array($user))
        {
            $this->set_id($user['id'])
                 ->set_username($user['username'])
                 ->set_password($user['password'])
                 ->set_first_name($user['firstname'])
                 ->set_last_name($user['lastname'])
                 ->set_phone($user['phone'])
                 ->set_title($user['title'])
                 ->set_type($user['type']);
        } 
        elseif(is_object($user))
        {
            // Use object parameters.
            $this->set_id($user->id)
                 ->set_username($user->username)
                 ->set_password($user->password)
                 ->set_first_name($user->firstname)
                 ->set_last_name($user->lastname)
                 ->set_phone($user->phone)
                 ->set_title($user->title)
                 ->set_type($user->type);
        }
        else
        {
            // Throw an error
            throw new Exception('The variable passed in is not an object or an array.');
        }

        return $this;
    }

    public function get_users($where = NULL, $limit = NULL, $start = NULL)
    {
        // If limit is not null then check where
        if( ! $limit === NULL )
        {
            // If where is not null do limit with where
            if( ! $where === NULL )
            {
                $user_array = $this->db->get_where('users', $where, $limit, $start)->result_array();
            }
            // else do limit with no where
            else
            {
                $user_array = $this->db->get_where('users', $limit, $start)->result_array();
            }
        }
        // else if where is not null do where
        elseif( ! $where === NULL )    
        {
            $user_array = $this->db->get_where('users', $where)->result_array();
        }
        // else get all of the users
        else
        {
            $user_array = $this->db->get('users')->result_array();
        }

        if($user_array)
        {
            $users = array();

            foreach($user_array as $u)
            {
                $user = new User($u['id']);
                array_push($users, $user);
            }

            return $users;
        }
        else
        {
            throw new Exception('There was no users returned.');
        }
    }

    // previously called countUsers($where = '')
    public function count_users()
    {
        return $this->db->get('users')->num_rows();
    }

    
    public function check_login($username, $password)
    {
        // Select the user based off of the username input.
        $result = $this->db->get_where('users', array('username' => $username));
        
        // If there was a result->
        if($result)
        {
            // Check to see if user's password matches input password.
            if(password_verify($password, $result->row(2)->password))
            {
                // Return user ID if it does.
                return $result->row(0)->id;
            } 
            else 
            {
                // Return FALSE if it does not match!
                return FALSE;
            }
        } 
        else 
        {
            // Return FALSE if there was no result! (meaning username did not match!)
            return FALSE;
        }
    }

    public function create_user_session()
    {
        // create array to pass into session
        $data = array(
            'user_id'            =>  $this->get_id(),
            'user_username'      =>  $this->get_username(),
            'user_first_name'    =>  $this->get_first_name(),
            'user_last_name'     =>  $this->get_last_name(),
            'user_title'         =>  $this->get_title(),
            'user_type'          =>  $this->get_type(),
            'logged_in'          =>  TRUE
        );

        // insert data into session.
        $this->session->set_userdata($data);
    }

    public function destroy_user_session()
    {
        // create array to pass into session
        $data = array(
            'user_id',
            'user_username',
            'user_first_name',
            'user_last_name',
            'user_title',
            'user_type',
            'logged_in'
        );

        // unset the session data using array.
        $this->session->unset_userdata($data);
    }

    // Previously called fetchEmployees($type)
    public function get_empoyees_by_type($type)
    {
        if( $emp_array = $this->db->get_where('users',['type'=>$type])->result_array() )
        {
            $employees = array();
            
                foreach($emp_array as $emp)
                {
                    $employee = new User();
                    $employee->set_user_data($emp);
                    array_push($employees, $employee);
                }
        
            return $employees;
        }
        else
        {
            // Log the database error.
            log_message('error', $this->db->error());

            return FALSE;
        }  
    }

    public function get_limited_users($limit, $start)
    {
        
        if( $user_array = $this->db->get_where('users', $limit, $start)->result_array() )
        {
            $users = array();
            
                foreach($user_array as $u)
                {
                    $user = new User();
                    $user->set_user_data($u);
                    array_push($users, $user);
                }
        
            return $users;
        }
        else
        {
            // Log the database error.
            log_message('error', $this->db->error());

            return FALSE;
        } 
        
    }

    /**
     * check_user_type
     * 
     * Returns true or false depending on parameters entered.
     *
     * @param int $id
     * @param string $type
     * @return bool
     */
    public function check_user_type($id, $type)
    {
        $this->set_user_data($id);
        if($this->get_type() == $type)
        {
            return TRUE;
        } 
        else
        {
            return FALSE;
        }
    }

    public function create()
    {
        // Insert this object into the database.
        if($this->db->insert('users', array(
                'username'      =>  $this->get_username(),
                'password'      =>  $this->get_password(),
                'first_name'    =>  $this->get_first_name(),
                'last_name'     =>  $this->get_last_name(),
                'phone'         =>  $this->get_phone(),
                'title'         =>  $this->get_title(),
                'type'          =>  $this->get_type()
                )))
        {
            // Return the newly inserted ID.
            return $this->db->insert_id();
        }
        else
        {
            // Log the error
            log_message('error', $this->db->error());

            // Return false
            return FALSE;
        }
    }

    public function update()
    {
        // Update the user based on this objects ID.
        return $this->db->update('users', $this, ['id' => $this->get_id()]);
    }

    public function delete($id = NULL)
    {
        // Delete the user by using an ID.
        if($id === NULL)
        {
            // Delete the user by using object's id property.
            return $this->db->delete('users', ['id'=>$this->get_id()]);
        } 
        else 
        {
            // Delete the user by using parameter id.
            return $this->db->delete('users', ['id'=>$id]);
        }
    }
}