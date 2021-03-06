<?php 
class Loan_model extends MY_model
{

    public $id;
    public $id_prestamista;

    public $id_cliente;
    public $cliente;

    public $monto = 0;
    public $porcentaje = 0;
    public $subtotal = 0;
    public $monto_total = 0;
    public $monto_pagado = 0;
    public $progreso = 0;
    public $deuda = 0;

    public $ciclo_pago = 'Diario';
    public $fecha_inicio;
    public $registerdate;
    public $status = '1';

    public $cant_cuotas = 0;
    public $cuotas = array();

    public $is_map = false;
    private $table_name = 'loans';

    function __construct()
    {
        parent::__construct();
    }

    /**
     * Map the model object whit one register in the database
     * @param  int $id the loan id databse
     * @return boolean     if the was correct the operation
     */
    public function map($id)
    {
        $loan = $this->get_data(array('id' => $id), $this->table_name)[0];
        if (!$loan) {
            return false;
        }

        $this->id_prestamista = $loan['id_prestamista'];

        // Map the client
        $this->load->model('admin/loan/Client_model');
        $client = new Client_model();
        $client->map($loan['id_cliente']);
        $this->cliente = $client;
        $this->id_cliente = $loan['id_cliente'];

        $this->id = $id;
        $this->monto = $loan['monto'];
        $this->porcentaje = $loan['porcentaje'];
        $this->subtotal = $loan['subtotal'];
        $this->monto_total = $loan['monto_total'];
        $this->monto_pagado = $loan['monto_pagado'];
        $this->ciclo_pago = $loan['ciclo_pago'];
        $this->cant_cuotas = $loan['cant_cuotas'];
        $this->deuda = $loan['monto_total'] - $loan['monto_pagado'];
        $this->fecha_inicio = DateTime::createFromFormat('Y-m-d', $loan['fecha_inicio']);
        $this->progreso = $loan['progreso'];
        $this->registerdate = DateTime::createFromFormat('Y-m-d H:i:s', $loan['registerdate']);
        $this->status = $loan['status'];
        $this->get_dues();
        $this->is_map = true;

        return true;
    }

    public function get_dues()
    {
        $this->cuotas = array();
        $cuotas = $this->get_data(array('id_prestamo' => $this->id), 'loans_dues');
        if ($cuotas) {
            $this->load->model('admin/loan/Due_model');
            foreach ($cuotas as $key => $cuota) {
                $Due = new Due_model();
                $Due->map_from_array($cuota);
                array_push($this->cuotas, $Due);
            }
        }
        return $this->cuotas;
    }

    public function create()
    {
        $registerdate = new DateTime();
        
        //Calculo de porcentaje
        $porcentaje = ((float)$this->porcentaje) / 100;
        $this->subtotal = $this->monto * $porcentaje;
        $this->monto_total = $this->monto + $this->subtotal;

        $insert = array(
            'id_prestamista' => $this->id_prestamista,
            'id_cliente' => $this->id_cliente,
            'monto' => $this->monto,
            'monto_total' => $this->monto_total,
            'monto_pagado' => $this->monto_pagado,
            'subtotal' => $this->subtotal,
            'porcentaje' => $this->porcentaje,
            'ciclo_pago' => $this->ciclo_pago,
            'cant_cuotas' => $this->cant_cuotas,
            'progreso' => $this->progreso,
            'fecha_inicio' => $this->fecha_inicio->format('Y-m-d'),
            'registerdate' => $registerdate->format('Y-m-d H:i:s'),
            'status' => $this->status
        );

        $this->load->model('admin/loan/Client_model');
        $client = new Client_model();
        $client->map($this->id_cliente);
        $this->cliente = $client;

        if ($this->set_data($insert, $this->table_name)) {
            $this->id = ($this->get_data(array('registerdate' => $registerdate->format('Y-m-d H:i:s')), $this->table_name)[0])['id'];

            $monto_cuotas = $this->monto_total / $this->cant_cuotas;
            $cuota_numero = 1;

            $this->load->model('admin/loan/Due_model');
            $Cuota = new Due_model();

            $fecha_pago = DateTime::createFromFormat('Y-m-d', $this->fecha_inicio->format('Y-m-d'));

            $Cuota->id_prestamo = $this->id;
            $Cuota->fecha_pago = $fecha_pago;
            $Cuota->numero_cuota = $cuota_numero;
            $Cuota->monto_total = $monto_cuotas;
            $Cuota->monto_pagado = 0;
            $Cuota->estado = 'Pendiente';
            $Cuota->fecha_pagado = DateTime::createFromFormat('Y-m-d', '0000-00-00');
            $Cuota->status = '1';
            $Cuota->create();

            array_push($this->cuotas, $Cuota);

            for ($i = 1; $i < $this->cant_cuotas; $i++) {
                $Cuota = new Due_model();
                switch ($this->ciclo_pago) {
                    case 'Diario':
                        $step = 'P1D';
                        //If the day is saturday then sum 2 day to monday
                        if ($fecha_pago->format('N') === '6') {
                            $step = 'P2D';
                        }
                        $fecha_pago->add(new DateInterval($step));
                        break;
                    case 'Semanal':
                        $step = 'P1W';
                        //If the day is saturday then sum 2 day to monday
                        if ($fecha_pago->format('N') === '6') {
                            $step = 'P1D1W';
                        }
                        $fecha_pago->add(new DateInterval($step));
                        break;
                    case 'Quincenal':
                        $step = 'P2W';
                        //If the day is saturday then sum 2 day to monday
                        if ($fecha_pago->format('N') === '6') {
                            $step = 'P1D2W';
                        }
                        $fecha_pago->add(new DateInterval($step));
                        break;
                    case 'Mensual':
                        $step = 'P1M';
                        //If the day is saturday then sum 2 day to monday
                        if ($fecha_pago->format('N') === '6') {
                            $step = 'P1D1M';
                        }
                        $fecha_pago->add(new DateInterval($step));
                        break;
                    case 'Bimensual':
                        $step = 'P2M';
                        //If the day is saturday then sum 2 day to monday
                        if ($fecha_pago->format('N') === '6') {
                            $step = 'P1D2M';
                        }
                        $fecha_pago->add(new DateInterval($step));
                        break;
                    case 'Trimestral':
                        $step = 'P3M';
                        //If the day is saturday then sum 2 day to monday
                        if ($fecha_pago->format('N') === '6') {
                            $step = 'P1D3M';
                        }
                        $fecha_pago->add(new DateInterval($step));
                        break;
                    case 'Semestral':
                        $step = 'P6M';
                        //If the day is saturday then sum 2 day to monday
                        if ($fecha_pago->format('N') === '6') {
                            $step = 'P1D6M';
                        }
                        $fecha_pago->add(new DateInterval($step));
                        break;
                    case 'Anual':
                        $step = 'P1Y';
                        //If the day is saturday then sum 2 day to monday
                        if ($fecha_pago->format('N') === '6') {
                            $step = 'P1D1Y';
                        }
                        $fecha_pago->add(new DateInterval($step));
                        break;
                    case 'Bianual':
                        $step = 'P2Y';
                        //If the day is saturday then sum 2 day to monday
                        if ($fecha_pago->format('N') === '6') {
                            $step = 'P1D2Y';
                        }
                        $fecha_pago->add(new DateInterval($step));
                        break;

                    default:

                        break;
                }
                $cuota_numero++;

                $Cuota->id_prestamo = $this->id;
                $Cuota->fecha_pago = $fecha_pago;
                $Cuota->numero_cuota = $cuota_numero;
                $Cuota->monto_total = $monto_cuotas;
                $Cuota->monto_pagado = 0;
                $Cuota->estado = 'Pendiente';
                $Cuota->fecha_pagado = DateTime::createFromFormat('Y-m-d', '0000-00-00');
                $Cuota->status = '1';
                $Cuota->create();

                array_push($this->cuotas, $Cuota);

            }

            $this->is_map = true;

            return true;
        } else {
            return false;
        }
    }

    public function update()
    {
        if (!$this->id) {
            return false;
        }

        $update = array(
            'id_prestamista' => $this->id_prestamista,
            'id_cliente' => $this->id_cliente,
            'monto' => $this->monto,
            'monto_total' => $this->monto_total,
            'monto_pagado' => $this->monto_pagado,
            'porcentaje' => $this->porcentaje,
            'ciclo_pago' => $this->ciclo_pago,
            'cant_cuotas' => $this->cant_cuotas,
            'progreso' => $this->progreso,
            'fecha_inicio' => $this->fecha_inicio->format('Y-m-d'),
            'registerdate' => $this->registerdate->format('Y-m-d'),
            'status' => $this->status
        );

        $where = array('id' => $this->id);
        return $this->update_data($where, $update, $this->table_name);
    }

    public function set_status($status = false)
    {
        if (!$this->id) {
            return false;
        }
        $where = array('id' => $this->id);
        if ($status === '0' || $status === '1') {
            $update = array('status' => $status);
            $this->status = $status;
        } else {
            if ($this->status === '1') {
                $update = array('status' => '0');
                $this->status = '0';
            } else {
                $update = array('status' => '1');
                $this->status = '1';
            }
        }
        return $this->update_data($where, $update, $this->table_name);
    }

    public function delete()
    {
        if (!$this->id) {
            return false;
        }
        $where = array('id' => $this->id);
        $this->delete_data($where, $this->table_name);
    }

    public function set_payment($abono, $id_cuota = false, $numero_cuota = false)
    {
        // If the object model not is maping with the database
        if (!$this->is_map) {
            return false;
        }
        $abono_real = $abono;
        $abono = (float)$abono;

        //Si el monto a ingresar es mayor que el monto total debido
        if ($abono > ($this->monto_total-$this->monto_pagado)) {
            $abono = $this->monto_total - $this->monto_pagado;
        }

        echo $abono;

        // The next obj due to pay 
        $due = $this->get_index_due_to_pay();
        $today = new DateTime();

        //No hay una cuota para hoy, entonces procedo a crearla
        if ($due === -1) {
            $cuota = array(
                'id_prestamo' => $this->id,
                'numero_cuota' => 0,
                'fecha_pago' => $today->format('Y-m-d'),
                'monto_total' => 0,
                'monto_pagado' => $abono,
                'estado' => 'Pagado',
                'fecha_pagado' => $today->format('Y-m-d'),
                'status' => '1'
            );
            $this->set_data($cuota, 'loans_dues');

        }else{

            $due->monto_pagado += $abono;
            $due->fecha_pagado = $today;
            if($due->monto_pagado >= $due->monto_total){
                $due->estado = 'Pagado';
            }else{
                $due->estado = 'Pendiente';
            }
            
            $due->update();
        }
        $this->update_progress();
        return $abono_real - $abono;
    }

    public function update_progress()
    {
        $this->monto_pagado = $this->get_pay_progress();
        $progreso = ($this->monto_pagado * 100) / $this->monto_total;
        
        $this->progreso = $progreso;
        if($this->progreso >= 100){
            $this->status = 0;
        }
        $this->deuda = $this->monto_total - $this->monto_pagado;
        $this->update();
        $this->get_dues();
    }

    public function get_index_due_to_pay()
    {
        $today = new DateTime();
        $today = $today->format('Y-m-d');
        foreach ($this->cuotas as $key => $cuota) {
            if ($cuota->fecha_pago->format('Y-m-d') === $today) {
                return $this->cuotas[$key];
            }
        }
        return -1;
    }

    public function get_pay_progress()
    {
        // If the object model not is maping with the database
        if (!$this->is_map) {
            return false;
        }
        $this->db->select('SUM(monto_pagado) AS monto_pagado');
        $this->db->where(array('id_prestamo' => $this->id));
        $query = $this->db->get('loans_dues');
        return (($query->result_array())[0])['monto_pagado'];
    }

    public function get_cliente($data = 'all', $limit = '', $order = array('id', 'ASC'))
    {
        $limit ? $this->db->limit($limit) : null;
        if ($order !== '') {
            $this->db->order_by($order[0], $order[1]);
        }
        if ($data !== "all") {
            $query = $this->db->get_where('clients', $data);
            if ($query->num_rows() > 0) {
                return $query->result_array();
            }
            return false;
        } else {
            $query = $this->db->get('clients');
            if ($query->num_rows() > 0) {
                return $query->result_array();
            }
            return false;
        }
    }

    public function get_cliente_extended($where = '', $limit = '', $order = array('id', 'ASC'))
    {
        $this->db->select('`user`.`username`, `clients`.*');
        $this->db->from('`user`, `clients`, `loans_user_client`');
        $this->db->where("user`.`id`=`loans_user_client`.`id_user` AND `clients`.`id`=`loans_user_client`.`id_client` $where");

        $limit ? $this->db->limit($limit) : null;

        if ($order !== '') {
            $this->db->order_by($order[0], $order[1]);
        }

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }

        return false;
    }

    public function get_cliente_prestamista($where = '', $limit = '', $order = array('user.id', 'ASC'))
    {
        $this->db->select('*');
        $this->db->from('`user`, `clients`');
        $this->db->where("user`.`id`=`clients`.`id_user_register` $where");

        $limit ? $this->db->limit($limit) : null;

        if ($order !== '') {
            $this->db->order_by($order[0], $order[1]);
        }

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }

        return false;
    }

    public function set_cliente($data)
    {
        return $this->db->insert('clients', $data);
    }

    public function update_cliente($data, $id)
    {
        $this->db->where('id', $id);
        return $this->db->update('clients', $data);
    }

    public function set_prestamo($data)
    {
        return $this->db->insert('loans', $data);
    }

    public function get_prestamo($data = 'all', $limit = '', $order = array('id', 'ASC'))
    {
        $limit ? $this->db->limit($limit) : null;
        if ($order !== '') {
            $this->db->order_by($order[0], $order[1]);
        }
        if ($data !== "all") {
            $query = $this->db->get_where('loans', $data);
            if ($query->num_rows() > 0) {
                return $query->result_array();
            }
            return false;
        } else {
            $query = $this->db->get('loans');
            if ($query->num_rows() > 0) {
                return $query->result_array();
            }
            return false;
        }
    }

    public function get_prestamos_extended($where = '', $limit = '', $order = array('id', 'ASC'))
    {
        $this->db->select('`user`.`username`, `loans`.*, `clients`.`nombre`, `clients`.`apellido`');
        $this->db->from('`user`, `loans`, `clients`');
        $this->db->where("`user`.`id`=loans.id_prestamista AND `loans`.`id_cliente`=`clients`.`id` $where");

        $limit ? $this->db->limit($limit) : null;

        if ($order !== '') {
            $this->db->order_by($order[0], $order[1]);
        }

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }

        return false;
    }

    public function set_cuota($data)
    {
        return $this->db->insert_batch('loans_dues', $data);
    }

    public function get_cuota_prestamo($where = '', $limit = '', $order = array('`loans_dues`.`id`', 'ASC'))
    {
        $limit ? $this->db->limit($limit) : null;
        if ($order !== '') {
            $this->db->order_by($order[0], $order[1]);
        }
        $this->db->from('`loans`, `loans_dues`');
        $this->db->where("`loans`.`id`=`loans_dues`.`id_prestamo` $where");
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    public function update_estados()
    {
        $update = array('`estado`' => 'Caida');
        $this->db->where('`fecha_pago` < CURRENT_DATE AND `monto_total` > `monto_pagado`', null, false);
        $this->db->set($update);
        return $this->db->update('loans_dues');
    }

    public function get_simple_next_dues($whereportion = '', $order_by = 'ORDER BY `loans_dues`.`fecha_pago` ASC', $limit = 'LIMIT 5')
    {
        $sql = "SELECT `loans`.`id` AS 'prestamo_id', `id_prestamista`, `id_cliente`, `loans_dues`.`monto_total`, `loans_dues`.`id`, `loans_dues`.`fecha_pago`, CONCAT(`clients`.`nombre`, ' ', `clients`.`apellido`) AS `cliente` FROM `loans`, `loans_dues`, `clients` WHERE `loans`.`id`=`loans_dues`.`id_prestamo` AND `loans_dues`.`estado` != 'Pagado' AND `loans_dues`.`fecha_pago`>CURRENT_DATE() AND `loans`.`id_cliente`=`clients`.`id` $whereportion $order_by $limit";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
}
?>