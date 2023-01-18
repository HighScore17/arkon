<div class="get-a-demo">
    <div class="left-side">
        <div class="form">
            <span class="icon-check02-ico check-icon" style="display: none;"></span>
            <div id="form-get-a-demo-container">
                <h2 class="title">
                    Get a
                </h2>
                <h1 class="subtitle">
                    demo
                </h1>
                <p class="banner">Tousled food truck polaroid, salvia bespoke small batch Pinterest Marfa. Fingerstache
                    authentic craft
                    beer, food truck Banksy Carles kale chips hoodie. Trust fund artisan master cleanse fingerstache
                    post-ironic.</p>
                <form id="form-get-a-demo">
                    <input type="text" class="form-control" placeholder="Name" name="fname" id="get-demo-fname"/>
                    <br/>
                    <input type="text" class="form-control" placeholder="Last name" name="lname" id="get-demo-lname"/>
                    <br/>
                    <input type="text" class="form-control" placeholder="Company" name="Company"
                           id="get-demo-company"/>
                    <br/>
                    <input type="email" class="form-control" placeholder="Email" name="email" id="get-demo-email"/>
                    <br/>
                    <input type="submit" class="button-submit" value="TRY ARKON NOW"/>
                    <p class="text-demo-error" id="form-get-demo-error"></p>
                </form>

            </div>
            <div id="form-get-demo-requested" style="display: none;">
                <h4 class="title">Thank you for your interest in Arkon Data!</h4>
                <h4 class="subtitle">
                    We will contact you shortly
                    <br/>

                </h4>
            </div>
        </div>
    </div>
    <div class="right-side">
        <div class="demo-image" >
            <img src=<?php echo get_template_directory_uri() . '/assets/img/arkon-get-demo.png' ?> alt="">
        </div>

    </div>
</div>
<script>
    jQuery('#form-get-a-demo').submit(function (e) {
        e.preventDefault();
        function validate_email(email) {
            if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email)) {
                return true
            }
            return false
        }
        function setError(err) {
            jQuery('#form-get-demo-error').text(err);
        }

        const email = jQuery('#get-demo-email').val();
        const fname = jQuery('#get-demo-fname').val();
        const company = jQuery('#get-demo-company').val();
        const lname = jQuery('#get-demo-lname').val();

        if (
            typeof email === "string" && email.trim() !== "" && validate_email(email) &&
            typeof fname === "string" && fname.trim() !== "" &&
            typeof company === "string" && company.trim() !== "" &&
            typeof lname === "string" && lname.trim() !== ""
        ) {
            setError("");
            jQuery.ajax({
                url: '/wp-admin/admin-ajax.php',
                type: "POST",
                data: {
                    action: 'send_email',
                    user_email: email,
                    user_fname: fname,
                    user_company: company,
                    user_lname: lname
                },
                success: function (result) {
                    jQuery(' #get-demo-email ').text(email);
                    jQuery('#form-get-a-demo-container').css('display', 'none');
                    jQuery('#form-get-demo-requested').css({
                        'display': 'block',
                        'width': '70%',
                        'top': '140px',
                        'padding': '10px',
                        'margin': '0 auto',
                        'max-width': '350px'
                    });
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    setError(' Failed to send demo request ')
                }
            })
        } else {
            setError(' Please fill all the mandatory fields. ')
        }
    })
</script>