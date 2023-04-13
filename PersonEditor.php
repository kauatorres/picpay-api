            <h3 class="card-title"><?= gettext('Family Info') ?></h3>
            <div class="card-tools">
                <input type="submit" class="btn btn-primary" value="<?= gettext('Save') ?>" name="PersonSubmit">
            </div>
        </div><!-- /.box-header -->
        <div class="card-body">
            <div class="form-group col-md-3">
                <label><?= gettext('Family Role') ?>:</label>
                <select name="FamilyRole" class="form-control">
                    <option value="0"><?= gettext('Unassigned') ?></option>
                    <option value="0" disabled>-----------------------</option>
                    <?php while ($aRow = mysqli_fetch_array($rsFamilyRoles)) {
        extract($aRow);
        echo '<option value="'.$lst_OptionID.'"';
        if ($iFamilyRole == $lst_OptionID) {
            echo ' selected';
        }
        echo '>'.$lst_OptionName.'&nbsp;';
    } ?>
                </select>
            </div>

            <div class="form-group col-md-6">
                <label><?= gettext('Family'); ?>:</label>
                <select name="Family" id="famailyId" class="form-control">
                    <option value="0" selected><?= gettext('Unassigned') ?></option>
                    <option value="-1"><?= gettext('Create a new family (using last name)') ?></option>
                    <option value="0" disabled>-----------------------</option>
                    <?php while ($aRow = mysqli_fetch_array($rsFamilies)) {
        extract($aRow);

        echo '<option value="'.$fam_ID.'"';
        if ($iFamily == $fam_ID || $_GET['FamilyID'] == $fam_ID) {
            echo ' selected';
        }
        echo '>'.$fam_Name.'&nbsp;'.FormatAddressLine($fam_Address1, $fam_City, $fam_State);
    } ?>
                </select>
            </div>
        </div>
    </div>
    <div class="card card-info clearfix">
        <div class="card-header">
            <h3 class="card-title"><?= gettext('Contact Info') ?></h3>
            <div class="card-tools">
                <input type="submit" class="btn btn-primary" value="<?= gettext('Save') ?>" name="PersonSubmit">
            </div>
        </div><!-- /.box-header -->
        <div class="card-body">
            <?php if (!SystemConfig::getValue('bHidePersonAddress')) { /* Person Address can be hidden - General Settings */ ?>
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-6">
                            <label>
                                <?php if ($bFamilyAddress1) {
        echo '<span style="color: red;">';
    }

        echo gettext('Address').' 1:';

        if ($bFamilyAddress1) {
            echo '</span>';
        } ?>
                            </label>
                            <input type="text" name="Address1"
                                   value="<?= htmlentities(stripslashes($sAddress1), ENT_NOQUOTES, 'UTF-8') ?>"
                                   size="30" maxlength="50" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label>
                                <?php if ($bFamilyAddress2) {
            echo '<span style="color: red;">';
        }

        echo gettext('Address').' 2:';

        if ($bFamilyAddress2) {
            echo '</span>';
        } ?>
                            </label>
                            <input type="text" name="Address2"
                                   value="<?= htmlentities(stripslashes($sAddress2), ENT_NOQUOTES, 'UTF-8') ?>"
                                   size="30" maxlength="50" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label>
                                <?php if ($bFamilyCity) {
            echo '<span style="color: red;">';
        }

        echo gettext('City').':';

        if ($bFamilyCity) {
            echo '</span>';
        } ?>
                            </label>
                            <input type="text" name="City"
                                   value="<?= htmlentities(stripslashes($sCity), ENT_NOQUOTES, 'UTF-8') ?>"
                                   class="form-control">
                        </div>
                    </div>
                </div>
                <p/>
                <div class="row">
                    <div class="form-group col-md-2">
                        <label for="StatleTextBox">
                            <?php if ($bFamilyState) {
            echo '<span style="color: red;">';
        }

        echo gettext('State').':';

        if ($bFamilyState) {
            echo '</span>';
        } ?>
                        </label>
                        <?php require 'Include/StateDropDown.php'; ?>
                    </div>
                    <div class="form-group col-md-2">
                        <label><?= gettext('None State') ?>:</label>
                        <input type="text" name="StateTextbox"
                               value="<?php if ($sPhoneCountry != 'United States' && $sPhoneCountry != 'Canada') {
            echo htmlentities(stripslashes($sState), ENT_NOQUOTES, 'UTF-8');
        } ?>"
                               size="20" maxlength="30" class="form-control">
                    </div>

                    <div class="form-group col-md-1">
                        <label for="Zip">
                            <?php if ($bFamilyZip) {
            echo '<span style="color: red;">';
        }

        echo gettext('Zip').':';

        if ($bFamilyZip) {
            echo '</span>';
        } ?>
                        </label>
                        <input type="text" name="Zip" class="form-control"
                            <?php
                            // bevand10 2012-04-26 Add support for uppercase ZIP - controlled by administrator via cfg param
                            if (SystemConfig::getBooleanValue('bForceUppercaseZip')) {
                                echo 'style="text-transform:uppercase" ';
                            }

        echo 'value="'.htmlentities(stripslashes($sZip), ENT_NOQUOTES, 'UTF-8').'" '; ?>
                               maxlength="10" size="8">
                    </div>
                    <div class="form-group col-md-2">
                        <label for="Zip">
                            <?php if ($bFamilyCountry) {
            echo '<span style="color: red;">';
        }

        echo gettext('Country').':';

        if ($bFamilyCountry) {
            echo '</span>';
        } ?>
                        </label>
                        <?php require 'Include/CountryDropDown.php'; ?>
                    </div>
                </div>
                <p/>
            <?php
    } else { // put the current values in hidden controls so they are not lost if hiding the person-specific info?>
                <input type="hidden" name="Address1"
                       value="<?= htmlentities(stripslashes($sAddress1), ENT_NOQUOTES, 'UTF-8') ?>"></input>
                <input type="hidden" name="Address2"
                       value="<?= htmlentities(stripslashes($sAddress2), ENT_NOQUOTES, 'UTF-8') ?>"></input>
                <input type="hidden" name="City"
                       value="<?= htmlentities(stripslashes($sCity), ENT_NOQUOTES, 'UTF-8') ?>"></input>
                <input type="hidden" name="State"
                       value="<?= htmlentities(stripslashes($sState), ENT_NOQUOTES, 'UTF-8') ?>"></input>
                <input type="hidden" name="StateTextbox"
                       value="<?= htmlentities(stripslashes($sState), ENT_NOQUOTES, 'UTF-8') ?>"></input>
                <input type="hidden" name="Zip"
                       value="<?= htmlentities(stripslashes($sZip), ENT_NOQUOTES, 'UTF-8') ?>"></input>
                <input type="hidden" name="Country"
                       value="<?= htmlentities(stripslashes($sCountry), ENT_NOQUOTES, 'UTF-8') ?>"></input>
            <?php
    } ?>
            <div class="row">
                <div class="form-group col-md-3">
                    <label for="HomePhone">
                        <?php
                        if ($bFamilyHomePhone) {
                            echo '<span style="color: red;">'.gettext('Home Phone').':</span>';
                        } else {
                            echo gettext('Home Phone').':';
                        }
                        ?>
                    </label>
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-phone"></i>
                        </div>
                        <input type="text" name="HomePhone"
                               value="<?= htmlentities(stripslashes($sHomePhone), ENT_NOQUOTES, 'UTF-8') ?>" size="30"
                               maxlength="30" class="form-control" data-inputmask='"mask": "<?= SystemConfig::getValue('sPhoneFormat')?>"' data-mask>
                        <br><input type="checkbox" name="NoFormat_HomePhone"
                                   value="1" <?php if ($bNoFormat_HomePhone) {
                            echo ' checked';
                        } ?>><?= gettext('Do not auto-format') ?>
                    </div>
                </div>
                <div class="form-group col-md-3">
                    <label for="WorkPhone">
                        <?php
                        if ($bFamilyWorkPhone) {
                            echo '<span style="color: red;">'.gettext('Work Phone').':</span>';
                        } else {
                            echo gettext('Work Phone').':';
                        }
                        ?>
                    </label>
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-phone"></i>
                        </div>
                        <input type="text" name="WorkPhone"
                               value="<?= htmlentities(stripslashes($sWorkPhone), ENT_NOQUOTES, 'UTF-8') ?>" size="30"
                               maxlength="30" class="form-control"
                               data-inputmask='"mask": "<?= SystemConfig::getValue('sPhoneFormatWithExt')?>"' data-mask/>
                        <br><input type="checkbox" name="NoFormat_WorkPhone"
                                   value="1" <?php if ($bNoFormat_WorkPhone) {
                            echo ' checked';
                        } ?>><?= gettext('Do not auto-format') ?>
                    </div>
                </div>

                <div class="form-group col-md-3">
                    <label for="CellPhone">
                        <?php
                        if ($bFamilyCellPhone) {
                            echo '<span style="color: red;">'.gettext('Mobile Phone').':</span>';
                        } else {
                            echo gettext('Mobile Phone').':';
                        }
                        ?>
                    </label>
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-phone"></i>
                        </div>
                        <input type="text" name="CellPhone"
                               value="<?= htmlentities(stripslashes($sCellPhone), ENT_NOQUOTES, 'UTF-8') ?>" size="30"
                               maxlength="30" class="form-control" data-inputmask='"mask": "<?= SystemConfig::getValue('sPhoneFormatCell')?>"' data-mask>
                        <br><input type="checkbox" name="NoFormat_CellPhone"
                                   value="1" <?php if ($bNoFormat_CellPhone) {
                            echo ' checked';
                        } ?>><?= gettext('Do not auto-format') ?>
                    </div>
                </div>
            </div>
            <p/>
            <div class="row">
                <div class="form-group col-md-4">
                    <label for="Email">
                        <?php
                        if ($bFamilyEmail) {
                            echo '<span style="color: red;">'.gettext('Email').':</span></td>';
                        } else {
                            echo gettext('Email').':</td>';
                        }
                        ?>
                    </label>
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-envelope"></i>
                        </div>
                        <input type="text" name="Email" id="Email"
                               value="<?= htmlentities(stripslashes($sEmail), ENT_NOQUOTES, 'UTF-8') ?>" size="30"
                               maxlength="100" class="form-control">
                        <?php if ($sEmailError) {
                            ?><span style="color: red;"><?php echo $sEmailError ?></span><?php
                        } ?>
                    </div>
                </div>
                <div class="form-group col-md-4">
                    <label for="WorkEmail"><?= gettext('Work / Other Email') ?>:</label>
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-envelope"></i>
                        </div>
                        <input type="text" name="WorkEmail"
                               value="<?= htmlentities(stripslashes($sWorkEmail), ENT_NOQUOTES, 'UTF-8') ?>" size="30"
                               maxlength="100" class="form-control">
                        <?php if ($sWorkEmailError) {
                            ?><span style="color: red;"><?php echo $sWorkEmailError ?></span></td><?php
                        } ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-4">
                    <label for="Facebook">
                        <?php
                        if ($bFacebook) {
                            echo '<span style="color: red;">'.gettext('Facebook').':</span></td>';
                        } else {
                            echo gettext('Facebook').':</td>';
                        }
                        ?>
                    </label>
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa-brands fa-facebook"></i>
                        </div>
                        <input type="text" name="Facebook"
                               value="<?= htmlentities(stripslashes($sFacebook), ENT_NOQUOTES, 'UTF-8') ?>" size="30"
                               maxlength="50" class="form-control">
                        <?php if ($sFacebookError) {
                            ?><span style="color: red;"><?php echo $sFacebookError ?></span><?php
                        } ?>
                    </div>
                </div>
                <div class="form-group col-md-4">
                    <label for="Twitter"><?= gettext('Twitter') ?>:</label>
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa-brands fa-twitter"></i>
                        </div>
                        <input type="text" name="Twitter"
                               value="<?= htmlentities(stripslashes($sTwitter), ENT_NOQUOTES, 'UTF-8') ?>" size="30"
                               maxlength="50" class="form-control">
                        <?php if ($sTwitterError) {
                            ?><span style="color: red;"><?php echo $sTwitterError ?></span></td><?php
                        } ?>
                    </div>
                </div>
                <div class="form-group col-md-4">
                      <label for="LinkedIn"><?= gettext('LinkedIn') ?>:</label>
                      <div class="input-group">
                          <div class="input-group-addon">
                              <i class="fa-brands fa-linkedin"></i>
                          </div>
                          <input type="text" name="LinkedIn"
                                 value="<?= htmlentities(stripslashes($sLinkedIn), ENT_NOQUOTES, 'UTF-8') ?>" size="30"
                                 maxlength="50" class="form-control">
                          <?php if ($sLinkedInError) {
                            ?><span style="color: red;"><?php echo $sLinkedInError ?></span></td><?php
                        } ?>
                      </div>
                  </div>
            </div>
        </div>
    </div>
    <div class="card card-info clearfix">
        <div class="card-header">
            <h3 class="card-title"><?= gettext('Membership Info') ?></h3>
            <div class="card-tools">
                <input type="submit" class="btn btn-primary" value="<?= gettext('Save') ?>" name="PersonSubmit">
            </div>
        </div><!-- /.box-header -->
        <div class="card-body">
            <div class="row">
              <div class="form-group col-md-3 col-lg-3">
                <label><?= gettext('Classification') ?>:</label>
                <select id="Classification" name="Classification" class="form-control">
                  <option value="0"><?= gettext('Unassigned') ?></option>
                  <option value="0" disabled>-----------------------</option>
                  <?php while ($aRow = mysqli_fetch_array($rsClassifications)) {
                            extract($aRow);
                            echo '<option value="'.$lst_OptionID.'"';
                            if ($iClassification == $lst_OptionID) {
                                echo ' selected';
                            }
                            echo '>'.$lst_OptionName.'&nbsp;';
                        } ?>
                </select>
              </div>
                <div class="form-group col-md-3 col-lg-3">
                    <label><?= gettext('Membership Date') ?>:</label>
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </div>
                        <!-- Philippe Logel -->
                        <input type="text" name="MembershipDate" class="form-control date-picker"
                               value="<?= change_date_for_place_holder($dMembershipDate) ?>" maxlength="10" id="sel1" size="11"
                               placeholder="<?= SystemConfig::getValue("sDatePickerPlaceHolder") ?>">
                        <?php if ($sMembershipDateError) {
                            ?><span style="color: red;"><?= $sMembershipDateError ?></span><?php
                        } ?>
                    </div>
                </div>
              <?php if (!SystemConfig::getBooleanValue('bHideFriendDate')) { /* Friend Date can be hidden - General Settings */ ?>
                <div class="form-group col-md-3 col-lg-3">
                  <label><?= gettext('Friend Date') ?>:</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" name="FriendDate" class="form-control date-picker"
                           value="<?= change_date_for_place_holder($dFriendDate) ?>" maxlength="10" id="sel2" size="10"
                           placeholder="<?= SystemConfig::getValue("sDatePickerPlaceHolder") ?>">
                    <?php if ($sFriendDateError) {
                            ?><span style="color: red;"><?php echo $sFriendDateError ?></span><?php
                        } ?>
                  </div>
                </div>
              <?php
                        } ?>
            </div>
        </div>
    </div>
  <?php if ($numCustomFields > 0) {
                            ?>
    <div class="card card-info clearfix">
        <div class="card-header">
            <h3 class="card-title"><?= gettext('Custom Fields') ?></h3>
            <div class="card-tools">
                <input type="submit" class="btn btn-primary" value="<?= gettext('Save') ?>" name="PersonSubmit">
            </div>
        </div><!-- /.box-header -->
        <div class="card-body">
            <?php if ($numCustomFields > 0) {
                                mysqli_data_seek($rsCustomFields, 0);

                                while ($rowCustomField = mysqli_fetch_array($rsCustomFields, MYSQLI_BOTH)) {
                                    extract($rowCustomField);

                                    if (AuthenticationManager::GetCurrentUser()->isEnabledSecurity($aSecurityType[$custom_FieldSec])) {
                                        echo "<div class='row'><div class=\"form-group col-md-3\"><label>".$custom_Name.'</label>';

                                        if (array_key_exists($custom_Field, $aCustomData)) {
                                            $currentFieldData = trim($aCustomData[$custom_Field]);
                                        } else {
                                            $currentFieldData = '';
                                        }

                                        if ($type_ID == 11) {
                                            $custom_Special = $sPhoneCountry;
                                        }

                                        formCustomField($type_ID, $custom_Field, $currentFieldData, $custom_Special, !isset($_POST['PersonSubmit']));
                                        if (isset($aCustomErrors[$custom_Field])) {
                                            echo '<span style="color: red; ">'.$aCustomErrors[$custom_Field].'</span>';
                                        }
                                        echo '</div></div>';
                                    }
                                }
                            } ?>
        </div>
    </div>
  <?php
                        } ?>
    <div class="text-right">
    <input type="submit" class="btn btn-primary" id="PersonSaveButton" value="<?= gettext('Save') ?>" name="PersonSubmit">
    <?php if (AuthenticationManager::GetCurrentUser()->isAddRecordsEnabled()) {
                            echo '<input type="submit" class="btn btn-primary" value="'.gettext('Save and Add').'" name="PersonSubmitAndAdd">';
                        } ?>
    <input type="button" class="btn btn-primary" value="<?= gettext('Cancel') ?>" name="PersonCancel"
           onclick="javascript:document.location='v2/people';">
        <p><br/></p>
    </div>
</form>

<script nonce="<?= SystemURLs::getCSPNonce() ?>" >
	$(function() {
		$("[data-mask]").inputmask();
		$("#famailyId").select2();;
	});
</script>

<?php require 'Include/Footer.php' ?>
