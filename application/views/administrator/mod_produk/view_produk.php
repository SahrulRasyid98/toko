



            <div class="col-xs-12">  
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Semua Produk</h3>
                  <a class='pull-right btn btn-primary btn-sm' href='<?php echo base_url(); ?>administrator/tambah_produk'>Tambahkan Data</a>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table id="example1" class="table table-bordered table-striped table-condensed">
                    <thead>
                      <tr>
                        <th style='width:30px'>No</th>
                        <th>Nama Produk</th>
                        <th>Harga Modal</th>
                        <th>Harga Reseller</th>
                        <th>Harga Konsumen</th>
                        <th>Biaya Pesan</th>
                        <th>Biaya Simpan (%)</th>
                        <th>Stok</th>
                        <th>Satuan</th>
                        <th>Berat</th>
                        <th>EOQ</th>
                        <th>Pemesanan /th</th>
                        <th>Periode Pemesanan</th>
                        <th style='width:70px'>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                  <?php 
                    $no = 1;
                    foreach ($record as $row){
                      $jual = $this->model_app->jual($row['id_produk'])->row_array();
                      $beli = $this->model_app->beli($row['id_produk'])->row_array();
                      
                      


                    echo "<tr><td>$no</td>
                              <td>$row[nama_produk]</td>
                              <td>Rp ".rupiah($row['harga_beli'])."</td>
                              <td>Rp ".rupiah($row['harga_reseller'])."</td>
                              <td>Rp ".rupiah($row['harga_konsumen'])."</td>
                              <td>Rp ".rupiah($row['biaya_pesan'])."</td>
                              <td>$row[biaya_simpan] %</td>
                              <td>".($beli['beli']-$jual['jual'])."</td>
                              <td>$row[satuan]</td>
                              <td>$row[berat] Gram</td>";


                            $thun_lalu=date('Y')-1;  
                            $q_jmluunit_tahun_lalu=$this->db->query("SELECT  SUM(IF( YEAR(p.waktu_beli) ='$thun_lalu', d.jumlah_pesan, 0)) AS jml_pesantahun from rb_pembelian_detail d join rb_pembelian p on p.id_pembelian=d.id_pembelian where d.id_produk='$row[id_produk]'")->result();
                        foreach ($q_jmluunit_tahun_lalu as $jmluunit_tahun_lalu) 
                                {
                                  $kebutuhan_pertahun=$jmluunit_tahun_lalu->jml_pesantahun;

                                  $r_eoq = ( 2 * $kebutuhan_pertahun * $row['biaya_pesan']) / (($row['biaya_simpan']/100) * $row['harga_beli']);  // rumus eoq


                                  echo "<td>".$eoq = round(sqrt($r_eoq), 0, PHP_ROUND_HALF_UP)." unit </td>";  
                                  echo "<td>".round($kebutuhan_pertahun /$eoq)." x </td>";
                                  echo "<td>".round(360/($kebutuhan_pertahun/$eoq))." Hari </td>";
                                }
                              echo "
                              <td><center>
                                <a class='btn btn-success btn-xs' title='Edit Data' href='".base_url()."administrator/edit_produk/$row[id_produk]'><span class='glyphicon glyphicon-edit'></span></a>
                                <a class='btn btn-danger btn-xs' title='Delete Data' href='".base_url()."administrator/delete_produk/$row[id_produk]' onclick=\"return confirm('Apa anda yakin untuk hapus Data ini?')\"><span class='glyphicon glyphicon-remove'></span></a>
                              </center></td>
                          </tr>";
                      $no++;
                    }
                  ?>
                  </tbody>
                </table>
              </div>