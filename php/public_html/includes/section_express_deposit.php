<!-- Start Quick Contact Form -->
<section class="bg-dark text-white mt--15">
	<div class="absolute-full w-100 overflow-hidden opacity-9"><img alt="..." class="img-fluid" height="2000" src="../assets/images/masks/shape-line-lense.svg" width="2000"></div>
	<div class="container">
		<div class="row">

			
			<div class="col-4 p--20" data-aos="flip-right" data-aos-duration="0" data-aos-delay="0">
				<h4>Express Deposit Form</h4>
				<hr class="bg-gray-800">
				<form id="fcf-form-id" method="post" action="../php/contact-form-process.php">
				
					<div class="form-label-group mb-3">
						<input required placeholder="uPoker Name" id="upoker_name" name="upoker_name" type="text" class="form-control">
						<label for="upoker_name">uPoker Name</label>
					</div>

					<div class="form-label-group mb-3">
						<input required placeholder="uPoker ID" id="upoker_id" name="upoker_id" type="number" min="100000" max="999999" class="form-control">
						<label for="upoker_id">uPoker ID</label>
					</div>

					<div class="form-label-group mb-3">
						<input required placeholder="Mobile Number" id="mobile_number" name="mobile_number" type="tel" pattern="[61]\d\d\d\d\d\d\d\d\d\d" class="form-control">
						<label for="mobile_number">Mobile With Country Code (61422254832)</label>
						<div class="invalid-feedback">That didn't work.</div>
					</div>

					<div class="form-label-group mb-3">
						<input required placeholder="Deposit Amount" id="deposit_amount" name="deposit_amount" type="number" min="20" max="1000" class="form-control">
						<label for="deposit_amount">Deposit Amount (AUD)</label>
					</div>

					<button type="submit" class="btn btn-primary btn-block"> <i class="fi fi-arrow-end"></i>Submit Deposit</button>

				</form>
			</div>


			<div class="col-12 col-lg-4 mb-4">
				<div class="mb-4" data-aos="fade-down" data-aos-duration="0" data-aos-delay="0"><img class="lazyload img-fluid" alt="Float The Flop Logo" data-src="../assets/images/float-logo/float-the-flop-logo-white-text-transparent.svg" width="370" height="106"></div>
				<div data-aos="fade-up" data-aos-duration="0" data-aos-delay="0">
					<strong>24/7 Player Support Desk</strong>
					<hr class="bg-gray-800">
				</div>
				<div data-aos="flip-left" data-aos-duration="0" data-aos-delay="0">
					<p><strong>Non-Members</strong>: Please contact us using the quick contact form or the live support option at the bottom of this page.<br>Alternatively, email:<br><a href="mailto:support&#64;float-the-flop.com">support&#64;float-the-flop.com</a></p>
					<hr class="bg-gray-800">
				</div>
				<div data-aos="flip-right" data-aos-duration="0" data-aos-delay="0">
					<p><strong>Members</strong>: Please lodge a support ticket from within your Player Portal.</p>
					<hr class="bg-gray-800">
				</div>
				<div data-aos="flip-left" data-aos-duration="0" data-aos-delay="0">
					<p><strong>Business Partners</strong>: Please contact us via your Client Portal or email:<br><a href="mailto:back.office&#64;float-the-flop.com">back.office&#64;float-the-flop.com</a></p>
				</div>
			</div>

			
		</div>
	</div>
</section>