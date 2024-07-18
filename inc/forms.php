<?php
function product_options($label = 'Product Interest')
{
?>
    <option value="" selected disabled><?php echo $label; ?></option>
    <option value="Product 1">Product 1</option>
    <option value="Product 2">Product 2</option>
    <option value="Product 3">Product 3</option>
    <option value="Other">Other</option>
<?php
}

function appointment_times($label = 'Time')
{
?>
    <option value="" selected disabled><?php echo $label; ?></option>
    <option value="Morning">Morning</option>
    <option value="Afternoon">Afternoon</option>
    <option value="Evening">Evening</option>
<?php
}

/*********************************
HERO FORM
 *********************************/
function display_hero_form()
{
    $num = 'form####';
    $action = '';
    $idstamp = '';

    ob_start(); ?>

    <form data-idstamp="<?php echo $idstamp; ?>" data-action="<?php echo base64_encode($action); ?>" action="" class="form wufoo" method="post" accept-charset="UTF-8" autocomplete="off" enctype="multipart/form-data" novalidate>
        <div class="form-group">
            <input name="Field1" class="form-control" data-bvalidator="minlength[2],required" type="text" value="" placeholder="Full Name" data-bvalidator-msg="Please enter your full name.">
        </div>
        <div class="form-group">
            <input name="Field2" class="form-control" data-bvalidator="email,required" type="email" value="" placeholder="Email Address" data-bvalidator-msg="Please enter your email address.">
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <input name="Field3" class="form-control phone_us" data-bvalidator="minlength[14],required" type="tel" value="" placeholder="Phone Number" data-bvalidator-msg="Please enter your phone number.">
            </div>
            <div class="form-group col-md-6">
                <input name="Field5" class="form-control zip_us" data-bvalidator="minlength[5],required" type="tel" value="" placeholder="ZIP" data-bvalidator-msg="Please enter your zipcode.">
            </div>
        </div>
        <div class="form-group form-select">
            <select name="Field6" class="form-control" data-bvalidator="required" data-bvalidator-msg="Please select an option.">
                <?php product_options(); ?>
            </select>
        </div>
        <div class="d-none hidden-inputs">
        <input class="ppc-source" type="text" name="Field###" maxlength="255" value="">
            <input class="utm_source" type="text" name="Field###" maxlength="255" value="">
            <input class="utm_campaign" type="text" name="Field###" maxlength="255" value="">
            <input class="utm_medium" type="text" name="Field###" maxlength="255" value="">
            <input class="utm_term" type="text" name="Field###" maxlength="255" value="">
            <input class="utm_content" type="text" name="Field###" maxlength="255" value="">
            <input class="utm_adgroup" type="text" name="Field###" maxlength="255" value="">
        </div>
        <div class="form-group form-submit">
            <input name="saveForm" class="btn btn-secondary" type="submit" value="Submit">
        </div>
        <div class="d-none">
            <label>Do Not Fill This Out</label>
            <input type="hidden" name="idstamp" value="" />
        </div>
    </form>

<?php $output = ob_get_clean();

    return $output;
}
//Create short code for use in WP editor
add_shortcode('form-hero', 'display_hero_form');


/*********************************
SIDEBAR FORM
 *********************************/
function display_sidebar_form()
{
    $num = 'form####';
    $action = '';
    $idstamp = '';

    ob_start(); ?>

    <form data-idstamp="<?php echo $idstamp; ?>" data-action="<?php echo base64_encode($action); ?>" action="" class="form wufoo sidebar" method="post" accept-charset="UTF-8" autocomplete="off" enctype="multipart/form-data" novalidate>
        <div class="form-group">
            <input name="Field1" class="form-control" data-bvalidator="minlength[2],required" type="text" value="" placeholder="Name" data-bvalidator-msg="Please enter your full name.">
        </div>
        <div class="form-group">
            <input name="Field2" class="form-control" data-bvalidator="email,required" type="email" value="" placeholder="Email" data-bvalidator-msg="Please enter your email address.">
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <input name="Field3" class="form-control phone_us" data-bvalidator="minlength[14],required" type="tel" value="" placeholder="Phone" data-bvalidator-msg="Please enter your phone number.">
            </div>
            <div class="form-group col-md-6">
                <input name="Field5" class="form-control zip_us" data-bvalidator="minlength[5],required" type="tel" value="" placeholder="ZIP" data-bvalidator-msg="Please enter your zipcode.">
            </div>
        </div>
        <div class="form-group form-select">
            <select name="Field6" class="form-control" data-bvalidator="required" data-bvalidator-msg="Please select an option.">
                <?php product_options(); ?>
            </select>
        </div>
        <div class="d-none hidden-inputs">
        <input class="ppc-source" type="text" name="Field###" maxlength="255" value="">
            <input class="utm_source" type="text" name="Field###" maxlength="255" value="">
            <input class="utm_campaign" type="text" name="Field###" maxlength="255" value="">
            <input class="utm_medium" type="text" name="Field###" maxlength="255" value="">
            <input class="utm_term" type="text" name="Field###" maxlength="255" value="">
            <input class="utm_content" type="text" name="Field###" maxlength="255" value="">
            <input class="utm_adgroup" type="text" name="Field###" maxlength="255" value="">
        </div>
        <div class="form-group form-submit">
            <input name="saveForm" class="btn btn-secondary" type="submit" value="Submit">
        </div>
        <div class="d-none">
            <label>Do Not Fill This Out</label>
            <input type="hidden" name="idstamp" value="" />
        </div>
    </form>

<?php $output = ob_get_clean();

    return $output;
}
//Create short code for use in WP editor
add_shortcode('form-sidebar', 'display_sidebar_form');


/*********************************
LIGHTBOX FORM
 *********************************/
function display_lightbox_form()
{
    $num = 'form####';
    $action = '';
    $idstamp = '';

    ob_start(); ?>

    <form data-idstamp="<?php echo $idstamp; ?>" data-action="<?php echo base64_encode($action); ?>" action="" class="d-none d-lg-block form wufoo" method="post" accept-charset="UTF-8" autocomplete="off" enctype="multipart/form-data" novalidate>
        <div class="form-group">
            <input name="Field1" class="form-control" data-bvalidator="minlength[2],required" type="text" value="" placeholder="Full Name" data-bvalidator-msg="Please enter your full name.">
        </div>
        <div class="form-group">
            <input name="Field2" class="form-control" data-bvalidator="email,required" type="email" value="" placeholder="Email Address" data-bvalidator-msg="Please enter your email address.">
        </div>
        <div class="form-group">
            <input name="Field3" class="form-control phone_us" data-bvalidator="minlength[14],required" type="tel" value="" placeholder="Phone Number" data-bvalidator-msg="Please enter your phone number.">
        </div>
        <div class="form-group">
            <input name="Field5" class="form-control zip_us" data-bvalidator="minlength[5],required" type="tel" value="" placeholder="ZIP" data-bvalidator-msg="Please enter your zipcode.">
        </div>
        <div class="form-group form-select">
            <select name="Field6" class="form-control" data-bvalidator="required" data-bvalidator-msg="Please select an option.">
                <?php product_options(); ?>
            </select>
        </div>
        <div class="d-none hidden-inputs">
        <input class="ppc-source" type="text" name="Field###" maxlength="255" value="">
            <input class="utm_source" type="text" name="Field###" maxlength="255" value="">
            <input class="utm_campaign" type="text" name="Field###" maxlength="255" value="">
            <input class="utm_medium" type="text" name="Field###" maxlength="255" value="">
            <input class="utm_term" type="text" name="Field###" maxlength="255" value="">
            <input class="utm_content" type="text" name="Field###" maxlength="255" value="">
            <input class="utm_adgroup" type="text" name="Field###" maxlength="255" value="">
        </div>
        <div class="form-group form-submit">
            <input name="saveForm" class="btn btn-primary" type="submit" value="Get Your Quote">
        </div>
        <div class="d-none">
            <label>Do Not Fill This Out</label>
            <input type="hidden" name="idstamp" value="" />
        </div>
    </form>

<?php $output = ob_get_clean();

    return $output;
}


/*********************************
SINGLE OFFER PAGE
 *********************************/
function display_offer_form()
{
    $num = 'form####';
    $action = '';
    $idstamp = '';
    ob_start();
    $offer = get_field('offer'); ?>

    <form data-idstamp="<?php echo $idstamp; ?>" data-action="<?php echo base64_encode($action); ?>" action="" class="form wufoo" method="post" accept-charset="UTF-8" autocomplete="off" enctype="multipart/form-data" novalidate>
        <div class="form-group">
            <input name="Field1" class="form-control" data-bvalidator="minlength[2],required" type="text" value="" placeholder="Full Name" data-bvalidator-msg="Please enter your full name.">
        </div>
        <div class="form-group">
            <input name="Field2" class="form-control" data-bvalidator="email,required" type="email" value="" placeholder="Email Address" data-bvalidator-msg="Please enter your email address.">
        </div>
        <div class="form-group">
            <input name="Field3" class="form-control phone_us" data-bvalidator="minlength[14],required" type="tel" value="" placeholder="Phone Number" data-bvalidator-msg="Please enter your phone number.">
        </div>
        <div class="form-group">
            <input name="Field5" class="form-control zip_us" data-bvalidator="minlength[5],required" type="tel" value="" placeholder="ZIP" data-bvalidator-msg="Please enter your zipcode.">
        </div>
        <div class="d-none hidden-inputs">
            <input class="offer" type="text" name="Field777" maxlength="255" value="<?php echo $offer['single_line_offer']; ?>">
            <input class="ppc-source" type="text" name="Field###" maxlength="255" value="">
            <input class="utm_source" type="text" name="Field###" maxlength="255" value="">
            <input class="utm_campaign" type="text" name="Field###" maxlength="255" value="">
            <input class="utm_medium" type="text" name="Field###" maxlength="255" value="">
            <input class="utm_term" type="text" name="Field###" maxlength="255" value="">
            <input class="utm_content" type="text" name="Field###" maxlength="255" value="">
            <input class="utm_adgroup" type="text" name="Field###" maxlength="255" value="">
        </div>
        <div class="form-group form-submit">
            <input name="saveForm" class="btn btn-primary" type="submit" value="Claim Offer">
        </div>
        <div class="d-none">
            <label>Do Not Fill This Out</label>
            <input type="hidden" name="idstamp" value="" />
        </div>
    </form>

<?php $output = ob_get_clean();

    return $output;
}
//Create short code for use in WP editor
add_shortcode('form-offer', 'display_offer_form');


/*********************************
CONTACT FORM
 *********************************/
function display_contact_form()
{
    $num = 'form####';
    $action = 'h';
    $idstamp = '';

    ob_start(); ?>

    <form data-idstamp="<?php echo $idstamp; ?>" data-action="<?php echo base64_encode($action); ?>" action="" class="form wufoo" method="post" accept-charset="UTF-8" autocomplete="off" enctype="multipart/form-data" novalidate>
        <div class="form-group">
            <input name="Field1" class="form-control" data-bvalidator="minlength[2],required" type="text" value="" placeholder="Full Name" data-bvalidator-msg="Please enter your full name.">
        </div>
        <div class="form-group">
            <input name="Field2" class="form-control" data-bvalidator="email,required" type="email" value="" placeholder="Email Address" data-bvalidator-msg="Please enter your email address.">
        </div>
        <div class="form-group">
            <input name="Field3" class="form-control phone_us" data-bvalidator="minlength[14],required" type="tel" value="" placeholder="Phone Number" data-bvalidator-msg="Please enter your phone number.">
        </div>
        <div class="form-row">
            <div class="form-group col-md-4">
                <input name="Field5" class="form-control zip_us" data-bvalidator="minlength[5],required" type="tel" value="" placeholder="ZIP" data-bvalidator-msg="Please enter your zipcode.">
            </div>
            <div class="form-group form-select col-md-8">
                <select name="Field6" class="form-control" data-bvalidator="required" data-bvalidator-msg="Please select an option.">
                    <?php product_options(); ?>
                </select>
            </div>
        </div>
        <div class="form-group text-left">
            <div class="form-check form-check-inline">
                <label>
                    <input name="Field7" class="form-check-input" type="checkbox" value="one">Option one
                </label>
            </div>
            <div class="form-check form-check-inline">
                <label>
                    <input name="Field8" class="form-check-input" type="checkbox" value="two">Option two
                </label>
            </div>
            <div class="form-check form-check-inline">
                <label>
                    <input name="Field9" class="form-check-input" type="checkbox" value="three">Option three
                </label>
            </div>
        </div>
        <div class="form-group text-left">
            <div class="form-check form-check-inline">
                <label>
                    <input name="Field10" class="form-check-input" type="radio" data-bvalidator="required" data-bvalidator-msg="Please select one." value="one">Option one
                </label>
            </div>
            <div class="form-check form-check-inline">
                <label>
                    <input name="Field10" class="form-check-input" type="radio" value="two">Option two
                </label>
            </div>
            <div class="form-check form-check-inline">
                <label>
                    <input name="Field10" class="form-check-input" type="radio" value="three">Option three
                </label>
            </div>
        </div>
        <div class="form-group">
            <textarea name="Field11" class="form-control" rows="5" value="" placeholder="Questions/Comments"></textarea>
        </div>
        <div class="d-none hidden-inputs">
            <input class="ppc-source" type="text" name="Field###" maxlength="255" value="">
            <input class="utm_source" type="text" name="Field###" maxlength="255" value="">
            <input class="utm_campaign" type="text" name="Field###" maxlength="255" value="">
            <input class="utm_medium" type="text" name="Field###" maxlength="255" value="">
            <input class="utm_term" type="text" name="Field###" maxlength="255" value="">
            <input class="utm_content" type="text" name="Field###" maxlength="255" value="">
            <input class="utm_adgroup" type="text" name="Field###" maxlength="255" value="">
        </div>
        <div class="form-group form-submit">
            <input name="saveForm" class="btn btn-primary" type="submit" value="Get Your Quote">
        </div>
        <div class="d-none">
            <label>Do Not Fill This Out</label>
            <input type="hidden" name="idstamp" value="" />
        </div>
    </form>

<?php $output = ob_get_clean();

    return $output;
}
//Create short code for use in WP editor
add_shortcode('form-contact', 'display_contact_form');
