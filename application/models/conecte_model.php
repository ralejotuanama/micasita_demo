<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Conecte_model extends CI_Model {

    public function getSolicitudById($id){
        $this->db->where('idClientes',$id);
      //  $this->db->limit(1);
        return $this->db->get('solicitudes')->result();
    }

    function getm($table,$fields,$where='',$perpage=0,$start=0,$one=false,$array='array'){
        
        $this->db->select($fields);
        $this->db->from($table);
        $this->db->order_by('idClientes','desc');
        $this->db->limit($perpage,$start);
        if($where){
            $this->db->where($where);
        }
        
        $query = $this->db->get();
        
        $result =  !$one  ? $query->result() : $query->row();
        return $result;
    }



    public function get__($table,$fields,$where='',$perpage=0,$start=0,$one=false,$array='array'){
        
        $this->db->select($fields);
        $this->db->from($table);
        $this->db->order_by('idClientes','desc');
        $this->db->limit($perpage,$start);
        if($where){
            $this->db->where($where);
        }
        
        $query = $this->db->get();
        
        $result =  !$one  ? $query->result() : $query->row();
        return $result;
    }

    function get($table,$fields,$where='',$perpage=0,$start=0,$one=false,$array='array'){
        
        $this->db->select($fields.',clientes.nombreCliente');
        $this->db->from($table);
        $this->db->join('clientes','clientes.idClientes = os.clientes_id');
        $this->db->limit($perpage,$start);
        $this->db->order_by('idOs','desc');
        if($where){
            $this->db->where($where);
        }
        
        $query = $this->db->get();
        
        $result =  !$one  ? $query->result() : $query->row();
        return $result;
    }

	public function getLastOs($cliente){
		$this->db->where('clientes_id',$cliente);
		$this->db->limit(5);
		return $this->db->get('os')->result();
	}	

	public function getLastCompras($cliente){
		$this->db->select('vendas.*,usuarios.nombre');
		$this->db->from('vendas');
		$this->db->join('usuarios', 'usuarios.idUsuarios = vendas.usuarios_id');
		$this->db->where('clientes_id',$cliente);
		$this->db->limit(5);
		return $this->db->get()->result();
	}


	public function getCompras($table,$fields,$where='',$perpage=0,$start=0,$one=false,$array='array',$cliente){
        
        $this->db->select($fields);
        $this->db->from($table);
        $this->db->join('usuarios', 'vendas.usuarios_id = usuarios.idUsuarios', 'left');
        $this->db->where('clientes_id', $cliente);
        $this->db->limit($perpage,$start);
        if($where){
            $this->db->where($where);
        }
        
        $query = $this->db->get();
        
        $result =  !$one  ? $query->result() : $query->row();
        return $result;
    }



    function getx($table,$fields,$where='',$perpage=0,$start=0,$one=false,$array='array'){
        
        $this->db->select($fields);
        $this->db->from($table);
        $this->db->order_by('idClientes','desc');
        $this->db->limit($perpage,$start);
        if($where){
            $this->db->where($where);
        }
        
        $query = $this->db->get();
        
        $result =  !$one  ? $query->result() : $query->row();
        return $result;
    }


    function gety($table,$fields,$where='',$perpage=0,$start=0,$one=false,$array='array'){
        
        $this->db->select($fields);
        $this->db->from($table);
        $this->db->order_by('idClientes','desc');
        $this->db->limit($perpage,$start);
        if($where){
            $this->db->where('idClientes',$where);
        }
        
        $query = $this->db->get();
        
        $result =  !$one  ? $query->result() : $query->row();
        return $result;
    }


    function geta($table,$fields,$where='',$perpage=0,$start=0,$one=false,$array='array'){
        
        $this->db->select($fields);
        $this->db->from($table);
        $this->db->order_by('idlinea','desc');
        $this->db->limit($perpage,$start);
        if($where){
            $this->db->where('idClientes',$where);
        }
        
        $query = $this->db->get();
        
        $result =  !$one  ? $query->result() : $query->row();
        return $result;
    }

    function getb($table,$fields,$where='',$perpage=0,$start=0,$one=false,$array='array'){
        
        $this->db->select($fields);
        $this->db->from($table);
        $this->db->order_by('idsolicitud','desc');
        $this->db->limit($perpage,$start);
        if($where){
            $this->db->where('idClientes',$where);
        }
        
        $query = $this->db->get();
        
        $result =  !$one  ? $query->result() : $query->row();
        return $result;
    }


    public function getOs($table,$fields,$where='',$perpage=0,$start=0,$one=false,$array='array',$cliente){
        
        $this->db->select($fields);
        $this->db->from($table);
        $this->db->join('usuarios', 'os.usuarios_id = usuarios.idUsuarios', 'left');
        $this->db->where('clientes_id', $cliente);
        $this->db->limit($perpage,$start);
        if($where){
            $this->db->where($where);
        }
        
        $query = $this->db->get();
        
        $result =  !$one  ? $query->result() : $query->row();
        return $result;
    }

    public function countsolicitudes($table,$estado){
    	$this->db->where('estadosolicitud', $estado);
		return $this->db->count_all($table);
    }

    public function count($table,$cliente){
    	$this->db->where('clientes_id', $cliente);
		return $this->db->count_all($table);
    }
    
    public function countx($table) {
        return $this->db->count_all($table);
    }

    public function obtenerA($table,$fields,$where='',$perpage=0,$start=0,$one=false,$array='array',$cliente){
        
        $this->db->select($fields);
        $this->db->from($table);
        $this->db->join('clientes', 'aparatos.IDclientes = clientes.idClientes', 'left');
        $this->db->where('aparatos.IDclientes', $cliente);
        $this->db->limit($perpage,$start);
        if($where){
            $this->db->where($where);
        }
        
        $query = $this->db->get();
        
        $result =  !$one  ? $query->result() : $query->row();
        return $result;
    }

    public function getDados(){
        
        $this->db->where('idClientes',$this->session->userdata('id'));
        $this->db->limit(1);
        return $this->db->get('clientes')->row();
    }


    function edit($table,$data,$fieldID,$ID){
        $this->db->where($fieldID,$ID);
        $this->db->update($table, $data);

        if ($this->db->affected_rows() >= 0)
        {
            return TRUE;
        }
        
        return FALSE;       
    }

    function add($table,$data,$returnId = false){
        $this->db->insert($table, $data);         
        if ($this->db->affected_rows() == '1')
        {
                        if($returnId == true){
                            return $this->db->insert_id($table);
                        }
            return TRUE;
        }
        
        return FALSE;       
    }


    function addLinea($table,$datax){
        $this->db->insert($table, $datax);         
        if ($this->db->affected_rows() == '1')
		{
			return TRUE;
		}
		
		return FALSE;       
    }



    public function addlineanueva($table,$datax,$returnId = false){
        $this->db->insert($table, $datax);         
        if ($this->db->affected_rows() == '1')
		{
            if($returnId == true){
                return $this->db->insert_id($table);
            }
			return TRUE;
		}
		
        return FALSE;            






    }

    
    function addSolicitud($table,$datax,$returnId = false){
        $this->db->insert($table, $datax);         
        if ($this->db->affected_rows() == '1')
		{
            if($returnId == true){
                return $this->db->insert_id($table);
            }
			return TRUE;
		}
		
        return FALSE;            


/*
        function add($table,$data,$returnId = false){
            $this->db->insert($table, $data);         
            if ($this->db->affected_rows() == '1')
            {
                            if($returnId == true){
                                return $this->db->insert_id($table);
                            }
                return TRUE;
            }
            
            return FALSE;       
        }
    
        
*/



    }


    function aparatoadd($table,$data){
        $this->db->insert($table, $data);         
        if ($this->db->affected_rows() == '1')
        {
            return TRUE;
        }
        
        return FALSE;       
    }


    function getById($id){
        $this->db->where('idClientes',$id);
        return $this->db->get('clientes')->row();
    }



    public function getById_clientes_lineas($id){
        $this->db->select('clientes.*,lineas.descripcion,idlinea,fechainicio,fechafin,estadolinea,comentario');
		$this->db->from('clientes');
		$this->db->join('lineas', 'clientes.idClientes = lineas.idClientes');
        $this->db->where('idlinea',$id);
        $query = $this->db->get();
        
       // $result =  !$one  ? $query->result() : $query->row();
        return $query->row();

		//return $this->db->get()->result();
    }

    public function getSolicitudById_($id){
        $this->db->where('idsolicitud',$id);
        return $this->db->get('solicitudes')->row();
    }

    public function getlineaById_($id){
        $this->db->where('idlinea',$id);
        return $this->db->get('lineas')->row();
    }

    public function anexarsolicitud($id, $anexo, $url, $thumb, $path,$tipo,$codsolicitud,$nombreoriginal){  
        $this->db->set('anexo',$anexo);
        $this->db->set('url',$url);
        $this->db->set('thumb',$thumb);
        $this->db->set('path',$path);
        $this->db->set('idClientes',$id);
        $this->db->set('os_id',$tipo);
        $this->db->set('idsolicitud',$codsolicitud);
        $this->db->set('nombre_original',$nombreoriginal);
        return $this->db->insert('anexos');
    }

    public function anexarlinea($id, $anexo, $url, $thumb, $path,$tipo,$codlinea,$nombreoriginal){  
        $this->db->set('anexo',$anexo);
        $this->db->set('url',$url);
        $this->db->set('thumb',$thumb);
        $this->db->set('path',$path);
        $this->db->set('idClientes',$id);
        $this->db->set('os_id',$tipo);
        $this->db->set('idlinea',$codlinea);
        $this->db->set('nombre_original',$nombreoriginal);
        return $this->db->insert('anexos');
    }

    
    public function getAnexos($os){ 

        $this->db->where('idClientes', $os);
      
        return $this->db->get('anexos')->result(); 
    }


    public function getAnexosfiltros($os,$tipo,$codsolicitud){ 

        $this->db->where('idClientes', $os);
        $this->db->where('os_id', $tipo);
        $this->db->where('idsolicitud', $codsolicitud);
        return $this->db->get('anexos')->result(); 
    }


    public function getAnexosfiltroslinea($os,$tipo,$codlinea){ 

        $this->db->where('idClientes', $os);
        $this->db->where('os_id', $tipo);
        $this->db->where('idlinea', $codlinea);
        return $this->db->get('anexos')->result(); 
    }


    public function getAnexosfiltroslinearpta($os,$tipo,$codlinea){ 

        
        $this->db->where('os_id', $tipo);
        $this->db->where('idlinea', $codlinea);
        return $this->db->get('anexos')->result(); 
        
    }


    public function getAnexosfiltrossolicitudrpta($os,$tipo,$codlinea){ 

        
        $this->db->where('os_id', $tipo);
        $this->db->where('idsolicitud', $codlinea);
        return $this->db->get('anexos')->result(); 
        
    }

    

    public function guardarsolicitud($nombre,$id)
    {
        $data3 = array(
            'nombre' => $titulo,
            'idClientes' => $id
        );

        return $this->db->insert('solicitudes', $data3);
    }



    
    //FUNCIÓN PARA INSERTAR LOS DATOS DE LA IMAGEN SUBIDA
   public function cargararchivos($titulo,$imagen,$id)
    {
        $data3 = array(
            'anexo' => $titulo,
            'thumb' => $imagen,
            'idClientes' => $id
        );

        return $this->db->insert('anexos', $data3);
    }


    public function cargardatosformulario($razonsocial,$telefono1,$telefono2,$telefono3,$correo1, $correo2, $departamento, $provincia, $distrito, $direccion, $referencia,$id)
    {

        $dataformulario = array(
       // 'documento' => $nrodocumento,
        'razonsocial' => $razonsocial,
        'telefono' => $telefono1,
        'celular' => $telefono2,
        'telefono3' => $telefono3,
        'email' => $correo1,
        'email2' => $correo2,
        'estado' => $departamento,
        'ciudad' => $provincia,
        'barrio' => $distrito,
        'ruc' => $direccion,
        'referencia' => $referencia
        );

      //  return $this->db->insert('clientes', $dataformulario);
   

      $this->db->where('idClientes',$id);
      $this->db->update('clientes', $dataformulario);

        
    }


   public function delete($table,$fieldID,$ID){
        $this->db->where($fieldID,$ID);
        $this->db->delete($table);
        if ($this->db->affected_rows() == '1')
		{
			return TRUE;
		}
		
		return FALSE;        
    }   



       
    function get_departamento(){
        $query = $this->db->get('ubdepartamento');
        return $query;  
    }


 

}

/* End of file conecte_model.php */
/* Location: ./application/models/conecte_model.php */