<?php
  $this->load->helper('string');
  $modalid = random_string('alnum', 16);
?>
<div class="box">
  <div class="box-header with-border">
    <h3 class="box-title">Herramientas</h3>
    <div class="box-tools pull-right">
    	<button class="btn btn-box-tool"><i class="fa fa-table"></i></button>
    </div>
  </div>
<!-- /.box-footer-->
</div>
<div class="row">
  <div class="col-xs-12">
    <div class="box">
      <div class="box-body">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs pull-right">
              <li class=""><a href="#tab_1-1" data-toggle="tab"><i class="fa fa-fw fa-history"></i> Historial</a></li>
              <li class=""><a href="#tab_2-2" data-toggle="tab" ><i class="fa fa-fw fa-credit-card"></i> Prestamos</a></li>
              <li class="active"><a href="#tab_3-2" data-toggle="tab" ><i class="fa fa-fw fa-newspaper-o"></i> Resumen</a></li>
              <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                  Opciones <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                  <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo base_url('admin/prestamo/nuevo/user/'.$cliente['id']); ?>">Registrar Prestamo</a></li>
                  <?php if ($this->session->userdata('level') < 3): ?>
                  <li role="presentation" class="divider"></li>
                  <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo base_url('admin/prestamo/cliente/editar/'.$cliente['id']); ?>">Editar</a></li>
                  <li role="presentation"><a role="menuitem" data-toggle="modal" data-target="<?php echo '#'.$modalid ?>" tabindex="-1" href="#!" data-table-reference="prestamos_clientes" data-value-id="<?php echo $cliente['id']; ?>" data-target="" data-delete-redirect="true" data-delete-redirectto="admin/prestamo/clientes" class="delete-data">Eliminar</a></li>
                  <?php endif ?>
                </ul>
              </li>
              <li class="pull-left header"><i class="fa fa-user"></i> <?php echo $cliente['nombre'].' '.$cliente['apellido'] ?></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane" id="tab_1-1">
                
                <div class="box-body">
              <?php if ($historial_prestamo): ?>
              <table id="example2" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <?php if ($this->session->userdata('level') < 3): ?>
                  <th>Prestamista</th>
                  <?php endif ?>
                  <th>Prestamo</th>
                  <th>Porcentaje</th>
                  <th>Total</th>
                  <th>Coutas</th>
                  <th>Ciclo de pago</th>
                  <th>Fecha de inicio</th>
                  <th>Progreso</th>
                </tr>
                </thead>
                <tbody>
                 <?php foreach ($historial_prestamo as $key => $prestamo): ?>
                   <tr>
                    <?php if ($this->session->userdata('level') < 3): ?>
                    <td><a href="<?php echo base_url('admin/user/view/'.$prestamo['id_prestamista']); ?>"><?php echo $prestamo['username'] ?></a></td>
                  <?php endif ?>
                     <td><?php echo $prestamo['monto'] ?> $&nbsp;<a title='Ver Cuotas' href="<?php echo base_url('admin/prestamo/cuotas/'.$prestamo['id']); ?>"><i class="fa fa-fw fa-search-plus"></i></a></td>
                     <td><?php echo $prestamo['porcentaje'] ?>%</td>
                     <td><?php echo $prestamo['monto_total'] ?> $</td>
                     <td><?php echo $prestamo['cant_cuotas'] ?></td>
                     <td><?php echo $prestamo['ciclo_pago'] ?></td>
                     <td><?php echo $prestamo['fecha_inicio'] ?></td>
                     <td><span class="badge bg-green"><?php echo $prestamo['progreso'] ?>%</span></td>
                   </tr>
                 <?php endforeach ?>
                </tbody>
                <tfoot>
                <tr>
                  <?php if ($this->session->userdata('level') < 3): ?>
                  <th>Prestamista</th>
                  <?php endif ?>
                  <th>Prestamo</th>
                  <th>Porcentaje</th>
                  <th>Total</th>
                  <th>Coutas</th>
                  <th>Ciclo de pago</th>
                  <th>Fecha de inicio</th>
                  <th>Progreso</th>
                </tr>
                </tfoot>
              </table>
            <?php else: ?>
            No hay prestamos registrados
            <?php endif ?>
            </div>
              
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_2-2">
                <div class="box-body">
              <?php if ($prestamos): ?>
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <?php if ($this->session->userdata('level') < 3): ?>
                  <th>Prestamista</th>
                  <?php endif ?>
                  <th>Prestamo</th>
                  <th>Porcentaje</th>
                  <th>Total</th>
                  <th>Coutas</th>
                  <th>Ciclo de pago</th>
                  <th>Fecha de inicio</th>
                </tr>
                </thead>
                <tbody>
                 <?php foreach ($prestamos as $key => $prestamo): ?>
                   <tr>
                    <?php if ($this->session->userdata('level') < 3): ?>
                    <td><a href="<?php echo base_url('admin/user/view/'.$prestamo['id_prestamista']); ?>"><?php echo $prestamo['username'] ?></a></td>
                    <?php endif ?>
                     <td><?php echo $prestamo['monto'] ?> $&nbsp;<a title='Ver Cuotas' href="<?php echo base_url('admin/prestamo/cuotas/'.$prestamo['id']); ?>"><i class="fa fa-fw fa-search-plus"></i></a></td>
                     <td><?php echo $prestamo['porcentaje'] ?>%</td>
                     <td><?php echo $prestamo['monto_total'] ?> $</td>
                     <td><?php echo $prestamo['cant_cuotas'] ?></td>
                     <td><?php echo $prestamo['ciclo_pago'] ?></td>
                     <td><?php echo $prestamo['fecha_inicio'] ?></td>
                   </tr>
                 <?php endforeach ?>
                </tbody>
                <tfoot>
                <tr>
                  <?php if ($this->session->userdata('level') < 3): ?>
                  <th>Prestamista</th>
                  <?php endif ?>
                  <th>Prestamo</th>
                  <th>Porcentaje</th>
                  <th>Total</th>
                  <th>Coutas</th>
                  <th>Ciclo de pago</th>
                  <th>Fecha de inicio</th>
                </tr>
                </tfoot>
              </table>
            <?php else: ?>
            No hay prestamos registrados
            <?php endif ?>
            </div>
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane active" id="tab_3-2">
                
                <div class="row">
                  <div class="col-lg-8">
                    <div class="row">
                      <div class="col-lg-3">
                        <div class="box box-success">
                          <div class="box-header with-border">
                            <h3 class="box-title">Básica</h3>
                          </div>
                          <!-- /.box-header -->
                          <div class="box-body">
                            <strong><i class="fa fa-phone margin-r-5"></i> Teléfono</strong>
                            <p class="text-muted"><a href="tel:<?php echo $cliente['telefono'] ?>"><?php echo $cliente['telefono'] ?></a></p>
                            <hr>
                            <strong><i class="fa fa-map-marker margin-r-5"></i> Location</strong>
                            <p class="text-muted"><a href="https://www.google.com.ar/maps/search/<?php echo urlencode($cliente['direccion']) ?>" target="_blank"><?php echo $cliente['direccion'] ?></a></p>
                            <hr>
                            <strong><i class="fa fa-calendar-plus-o margin-r-5"></i> Fecha de registro</strong>
                            <p class="text-muted"><?php echo $cliente['registerdate'] ?></p>
                          </div>
                          <!-- /.box-body -->
                        </div>
                        </div>
                        <div class="col-lg-9">
                          <div class="box box-primary">
                            <div class="box-header with-border">
                              <h3 class="box-title">Prestamos Activos</h3>
                            </div>
                            <!-- /.box-header -->
                            <?php if ($prestamos): ?>
                            <div class="box-body no-padding">
                              <table class="table table-condensed">
                                <tbody>
                                <tr>
                                  <th>Ciclo</th>
                                  <th>Monto</th>
                                  <th>Progreso</th>
                                  <th style="width: 40px">Porcentaje</th>
                                </tr>
                                  <?php foreach ($prestamos as $key => $prestamo): ?>
                                  <?php 
                                    $progresstyle = 'progress-bar-danger';
                                    $badge = 'bg-red'; 
                                    $progreso = $prestamo['progreso'];
                                    if ($progreso > 50 && $progreso < 80) {
                                      $progresstyle = 'progress-bar-yellow';
                                      $badge = 'bg-yellow'; 
                                    }
                                    if ($progreso > 80) {
                                      $progresstyle = 'progress-bar-primary';
                                      $badge = 'bg-light-blue';
                                    }
                                    if ($progreso == 100) {
                                      $progresstyle = 'progress-bar-success';
                                      $badge = 'bg-green';
                                    }
                                  ?>
                                  <tr>
                                    <td>
                                      <?php echo $prestamo['ciclo_pago'] ?>
                                    </td>
                                    <td>
                                      <?php echo $prestamo['monto'] ?>$&nbsp;<a title='Ver Cuotas' href="<?php echo base_url('admin/prestamo/cuotas/'.$prestamo['id']); ?>"><i class="fa fa-fw fa-search-plus"></i></a>
                                    </td>
                                    <td>
                                    <div class="progress progress-xs progress-striped active">
                                      <div class="progress-bar <?php echo $progresstyle ?>" style="width: <?php echo $prestamo['progreso'] ?>%"></div>
                                    </div>
                                  </td>
                                  <td><span class="badge <?php echo $badge ?>"><?php echo $progreso ?>%</span></td>
                                  </tr>  
                                <?php endforeach ?>
                              </tbody>
                            </table>
                            </div>
                          <?php else: ?>
                              <div class="box-body">No hay prestamos activos, <a href="<?php echo base_url('admin/prestamo/nuevo/user/'.$cliente['id']); ?>">Registrar nuevo</a></div>
                          <?php endif ?>
                            <!-- /.box-body -->
                          </div>
                        </div>
                      </div>
                    </div>
                  <div class="col-lg-4">
                    <div class="box box-solid bg-teal-gradient">
                    <div class="box-header">
                      <i class="fa fa-th"></i>
                      <h3 class="box-title">Pagos</h3>
                      <div class="box-tools pull-right">
                        <button type="button" class="btn bg-teal btn-sm" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn bg-teal btn-sm" data-widget="remove"><i class="fa fa-times"></i>
                        </button>
                      </div>
                    </div>
                    <div class="box-body border-radius-none">
                      <div class="chart" id="line-chart" style="height: 250px;"></div>
                    </div>
                  </div>
                  </div>
                </div>
              
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
      </div>
      <!-- /.box-body -->
    </div>
    <!-- /.box -->
  </div>
  <!-- /.col -->
</div>
<div class="modal fade" id="<?php echo $modalid; ?>" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span></button>
        <h4 class="modal-title">Eliminar Cliente</h4>
      </div>
      <div class="modal-body">
        <p>Esta accion eliminará el Cliente y todos los datos relacionados con éste</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-danger" data-delete-data="run" data-dismiss="modal">Continuar</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>