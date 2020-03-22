

  <main id="main">

    <!-- ***** Special Area Start ***** -->
    <section class="special-area bg-white section_padding_100" id="register">
        <div class="container">
        	<div class="row">
                <div class="col-12">
                    <!-- Section Heading Area -->
                    <div class="section-heading text-center">
                        <h1>J-Ride</h1>
                        <div class="line-shape"></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
		            <form class="form-horizontal" method="POST" action="<?php echo base_url(); ?>Regis/upload" enctype="multipart/form-data">
		          		<!-- <input name="redirect" type="hidden" value="<?php echo base_url()?>J-Ride" /> -->
		         		 <input type="hidden" name="job" value="1">
	         			 <input type="hidden" name="jenis" value="1">

						<div class="form-group">
				          <label for="name">Nama Depan</label>
				          <input class="form-control" name="nama_depan" placeholder="Nama Depan" type="text" />
				        </div>

						<div class="form-group">
				          <label for="name">Nama Belakang</label>
				          <input class="form-control" name="nama_belakang" placeholder="Nama Belakang" type="text"/>
				        </div>

						<div class="form-group">
							<label for="email">Email</label>
							<input class="form-control" name="email" placeholder="Email-ID" type="text" />
						</div>

						<div class="form-group">
							<label for="subject">Password</label>
							<input class="form-control" name="password" placeholder="Password" type="password" />
						</div>

						<div class="form-group">
				          <label for="name">Foto Profil</label>
				          <input class="form-control" name="foto_diri" placeholder="Foto Profil" type="file"/>
				        </div>

						<div class="form-group">
				          <label for="name">No. HP</label>
				          <input class="form-control" name="no_telepon" placeholder="No. HP" type="number" />
				        </div>

				        <div class="form-group">
				          <label for="name">Tanggal Lahir</label>
				          <input class="form-control" name="tgl_lahir" placeholder="Tanggal Lahir" type="date" />
				        </div>

				        <div class="form-group">
				          <label for="name">Tempat Lahir</label>
				          <input class="form-control" name="tempat_lahir" placeholder="Tempat Lahir" type="text" />
				        </div>

				        <div class="form-group">
				          <label for="name">KTP</label>
				          <input class="form-control" name="no_ktp" placeholder="KTP" type="number"  />
				        </div>

				        <div class="form-group">
				          <label for="name">Foto KTP</label>
				          <input class="form-control" name="foto_ktp" placeholder="Foto KTP" type="file" />
				        </div>

				        <div class="form-group">
				          <label for="name">Foto STNK</label>
				          <input class="form-control" name="foto_stnk" placeholder="Foto STNK" type="file" />
				        </div>

				        <div class="form-group">
				          <label for="name">Foto SIM</label>
				          <input class="form-control" name="foto_sim" placeholder="Foto SIM" type="file" />
				        </div>

				        <div class="form-group">
				          <label for="name">Bank</label>
				          <input class="form-control" name="nama_bank" placeholder="Bank" type="text" />
				        </div>

				        <div class="form-group">
				          <label for="name">Rekening</label>
				          <input class="form-control" name="rekening_bank" placeholder="Nomer Rekening" type="number" />
				        </div>

		 				<div class="form-group">
				          <div class="section-heading text-center">
		                        <h1>Transportation Info</h1>
		                        <div class="line-shape"></div>
		                    </div>
				        </div>

				        <div class="form-group">
				          <label for="name">Merek</label>
				          <input class="form-control" name="merk" placeholder="Merek" type="text" />
				        </div>

				        <div class="form-group">
				          <label for="name">Tipe</label>
				          <input class="form-control" name="tipe" placeholder="Tipe" type="text" />
				        </div>

				        <div class="form-group">
				          <label for="name">Nomor Kendaraan</label>
				          <input class="form-control" name="nomor_kendaraan" placeholder="Nomer Kendaraan" type="text" />
				        </div>

				        <div class="form-group">
				          <label for="name">Warna</label>
				          <input class="form-control" name="warna" placeholder="Warna Kendaraan" type="text" />
				        </div>

						<div class="form-group text-center">
							<button name="submit" type="submit" class="btn btn-success">Signup</button>
							<button name="cancel" type="reset" class="btn btn-success">Cancel</button>
						</div>
					</form>
				</div>
            </div>
        </div>
    </section>

</main>