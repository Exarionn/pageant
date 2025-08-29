<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
<script src="../js/jquery-3.6.0.min.js"></script>
<script src="../js/sweetalert2.all.min.js"></script>
<script src="../js/popper.min.js"></script>
<script src="../js/bootstrap.bundle.min.js"></script>
<script src="../js/stringFilter.js"></script>

<?php
    require '../include/connector/dbconn.php';
    include "../include/generatedKey.php"; 
    include "../include/query.php"; 
    include "../include/comparator.php"; 

    

//Event update
if(isset($_POST['updateEventCode'])){
    $updateEventCode = $_POST['updateEventCode'];
    $addedByCode = $_POST['addedByCode'];
    

    $eventEventUpdateQuery = viewEventUpdate;
    $stmt = $db->prepare($eventEventUpdateQuery);
    $stmt->bind_param("s", $updateEventCode);
    $stmt->execute();
    $resultEventEventUpdate = $stmt->get_result();

        // Check if there are rows in the result set
        if ($resultEventEventUpdate->num_rows > 0) {
            // Loop through each row
            while ($rowUpdate = mysqli_fetch_assoc($resultEventEventUpdate)) {
    ?>
                    <form action="../tri.super/superCode.php" method="POST">
                        <div class="row mb-3">

                            <input type="hidden" name="updateEventCode" value="<?=$rowUpdate['code']?>"/>
                            <input type="hidden" name="updatedBy" value="<?=$addedByCode?>"/>

                            <div class="col-sm-12 mb-3">
                                <div class="form-floating">
                                        <input class="form-control" id="updateEventName" name="updateEventName" type="text" value="<?= $rowUpdate['event_name']; ?>" placeholder="name@example.com" />
                                        <label for="input">Event Name</label>
                                </div>
                            </div>

                            <div class="col-sm-12 mb-3">
                                <div class="form-floating">
                                        <input class="filter form-control" id="updateEventPercentage" name="updateEventPercentage" type="text" value="<?= $rowUpdate['event_percentage']; ?>" data-maxlength="4" maxlength="4"placeholder="name@example.com" />
                                        <label for="input">Percentage</label>
                                </div>
                            </div>

                            <div class="col-sm-12 mb-3">
                                <div class="form-floating">
                                    <select class="form-select" id="updateEventType" name="updateEventType" required>
                                        <option value="" disabled>Select an option</option>
                                        <option value="PR" <?php echo ($rowUpdate['event_type'] == "PR") ? 'selected' : '' ?>>
                                            Preliminary Event
                                        </option>
                                        <option value="F" <?php echo ($rowUpdate['event_type'] == "F") ? 'selected' : '' ?>>
                                            Final Event
                                        </option>
                                        <option value="SP" <?php echo ($rowUpdate['event_type'] == "SP") ? 'selected' : '' ?>>
                                            Special Event
                                        </option>
                                    </select>
                                    <label for="input">Event Type</label>
                                </div>
                            </div>


                        </div>
                                <div><hr class="dropdown-divider"/></div>

                                <div class="mt-3 mb-0 d-flex bd-highlight">
                                    <button class="btn btn-outline-success btn-block ms-auto btn-sm" type="submit" name="UpdateEvent" id="UpdateEvent" style="text-decoration:none; -bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;">Update</button>
                                </div>
                    </form>
                <?php 
            }
        }
    }


//criteria update
if(isset($_POST['updateCriteriaCode'])){
    $updateCriteriaCode = $_POST['updateCriteriaCode'];
    $addedByCode = $_POST['addedByCode'];
    

    $eventCriteriaUpdateQuery = criteriaViewUpdate;
    $stmt = $db->prepare($eventCriteriaUpdateQuery);
    $stmt->bind_param("s", $updateCriteriaCode);
    $stmt->execute();
    $resultEventCriteriaUpdate = $stmt->get_result();

        // Check if there are rows in the result set
        if ($resultEventCriteriaUpdate->num_rows > 0) {
            // Loop through each row
            while ($rowUpdate = mysqli_fetch_assoc($resultEventCriteriaUpdate)) {
                $eventCriteriaListQuery = eventObjList;
                $stmt = $db->prepare($eventCriteriaListQuery);
                $stmt->bind_param("s", $rowUpdate['event_code']);
                $stmt->execute();
                $resultEventCriteriaList = $stmt->get_result();
                $fetchResultCriteria = $resultEventCriteriaList->fetch_assoc();
                $selectedCode = $fetchResultCriteria['code'];
    ?>
                    <form action="../tri.super/superCode.php" method="POST">
                        <div class="row mb-3">

                            <input type="hidden" name="updateCriteriaCode" value="<?=$rowUpdate['code']?>"/>
                            <input type="hidden" name="updatedBy" value="<?=$addedByCode?>"/>

                            <div class="col-sm-12 mb-3">
                                <div class="form-floating">
                                    <select class="form-select" name="updateEventCriteriaCode" id="updateEventCriteriaCode" required>
                                    <option value="" disabled>Select an option</option>
                                        <?php
                                        $eventNameColumn = 'event_name';
                                        $eventCodeColumn = 'code';
                                        $eventDropdownOptions = generateEventDropdownOptions(allEventList, $db, $eventCodeColumn, $eventNameColumn, $selectedCode);
                                        echo $eventDropdownOptions;
                                        ?>
                                    </select>
                                    <label for="updateEventCriteriaCode">Event Name</label>
                                </div>
                            </div>



                            <div class="col-sm-12 mb-3">
                                <div class="form-floating">
                                        <input class="form-control" id="updateCriteriaName" name="updateCriteriaName" type="text" value="<?= $rowUpdate['criteria_name']; ?>" placeholder="name@example.com" />
                                        <label for="input">Criteria Name</label>
                                </div>
                            </div>

                            <div class="col-sm-12 mb-3">
                                <div class="form-floating">
                                        <input class="filter form-control" id="updatePercentage" name="updatePercentage" type="text" value="<?= $rowUpdate['percent']; ?>" data-maxlength="4" maxlength="4"placeholder="name@example.com" />
                                        <label for="input">Percentage</label>
                                </div>
                            </div>

                            <div class="col-sm-12 mb-3">
                                <div class="form-floating">
                                    <select class="form-select" id="updateCriteriaType" name="updateCriteriaType" required>
                                        <option value="" disabled>Select an option</option>
                                        <option value="PR" <?php echo ($rowUpdate['criteria_type'] == "PR") ? 'selected' : '' ?>>
                                                Preliminary Event
                                        </option>
                                        <option value="F" <?php echo ($rowUpdate['criteria_type'] == "F") ? 'selected' : '' ?>>
                                                Final Event
                                        </option>
                                        <option value="SP" <?php echo ($rowUpdate['criteria_type'] == "SP") ? 'selected' : '' ?>>
                                                Special Event
                                        </option>
                                    </select>
                                    <label for="input">Event Type</label>
                                </div>
                            </div>


                        </div>
                                <div><hr class="dropdown-divider"/></div>

                                <div class="mt-3 mb-0 d-flex bd-highlight">
                                    <button class="btn btn-outline-success btn-block ms-auto btn-sm" type="submit" name="UpdateCriteria" id="UpdateCriteria" style="text-decoration:none; -bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;">Update</button>
                                </div>
                    </form>
                <?php 
            }
        }
    }

    
//Contestant update
if(isset($_POST['updateContestantCode'])){
    $updateContestantCode = $_POST['updateContestantCode'];
    
    $contestantUpdateQuery = viewContestantUpdate;
    $stmt = $db->prepare($contestantUpdateQuery);
    $stmt->bind_param("s", $updateContestantCode);
    $stmt->execute();
    $resultContestantUpdate = $stmt->get_result();

        // Check if there are rows in the result set
        if ($resultContestantUpdate->num_rows > 0) {
            // Loop through each row
            while ($rowUpdate = mysqli_fetch_assoc($resultContestantUpdate)) {
    ?>
                    <form action="../tri.super/superCode.php" method="POST">
                        <div class="row mb-3">

                            <input type="hidden" name="updateContestantCode" value="<?=$rowUpdate['code']?>"/>

                            <div class="col-sm-12 mb-3">
                                <div class="form-floating">
                                        <input class="form-control" id="updateContestantName" name="updateContestantName" type="text" value="<?= $rowUpdate['name']; ?>" data-maxlength="255" maxlength="255" required/>
                                        <label for="input">Name</label>
                                </div>
                            </div>

                            <div class="col-sm-12 mb-3">
                                <div class="form-floating">
                                        <input class="filter form-control" id="updateContestantSequence" name="updateContestantSequence" type="text" value="<?= $rowUpdate['sequence']; ?>" data-maxlength="6" maxlength="6" placeholder="" required/>
                                        <label for="input">Candidate Number</label>
                                </div>
                            </div>

                            

                            <div class="col-sm-12 mb-3">
                                <div class="form-floating">
                                    <select class="form-select" id="updateContestantCategory" name="updateContestantCategory" required>
                                            <option value="" disabled>~Select Category~</option>
                                            <option value="FE" <?php echo ($rowUpdate['category_code'] == "FE") ? 'selected' : '' ?>>
                                                Female
                                            </option>
                                            <option value="MA" <?php echo ($rowUpdate['category_code'] == "MA") ? 'selected' : '' ?>>
                                                Male
                                            </option>
                                                          <option value="B" <?php echo ($rowUpdate['category_code'] == "B") ? 'selected' : '' ?>>
                                                              Both Female/Male
                                                          </option>
                                                          <option value="LGBTQ-LES" <?php echo ($rowUpdate['category_code'] == "LGBTQ-LES") ? 'selected' : '' ?>>
                                                              Lesbian
                                                          </option>
                                                          <option value="LGBTQ-GAY" <?php echo ($rowUpdate['category_code'] == "LGBTQ-GAY") ? 'selected' : '' ?>>
                                                              Gay
                                                          </option>
                                                          <option value="LGBTQ-B" <?php echo ($rowUpdate['category_code'] == "LGBTQ-B") ? 'selected' : '' ?>>
                                                              Lesbian/Gay (Both)
                                                          </option>                                  
                                    </select>
                                    <label for="input">Category Type</label>
                                </div>
                            </div>

                            <div class="col-sm-12 mb-3">
                                <div class="form-floating">
                                    <select class="form-select" id="updateContestantGender" name="updateContestantGender" required>
                                        <option value="" disabled>~Select Gender~</option>
                                        <option value="F" <?php echo ($rowUpdate['gender'] == "F") ? 'selected' : '' ?>>
                                            Female
                                        </option>
                                        <option value="M" <?php echo ($rowUpdate['gender'] == "M") ? 'selected' : '' ?>>
                                            Male
                                        </option>
                                        <option value="B" <?php echo ($rowUpdate['gender'] == "B") ? 'selected' : '' ?>>
                                            Both Female/Male
                                        </option>
                                        <option value="LGBTQ-F" <?php echo ($rowUpdate['gender'] == "LGBTQ-F") ? 'selected' : '' ?>>
                                            Lesbian
                                        </option>
                                        <option value="LGBTQ-M" <?php echo ($rowUpdate['gender'] == "LGBTQ-M") ? 'selected' : '' ?>>
                                            Gay
                                        </option>
                                    </select>
                                    <label for="input">Gender</label>
                                </div>
                            </div>

                            
                        </div>
                                <div><hr class="dropdown-divider"/></div>

                                <div class="mt-3 mb-0 d-flex bd-highlight">
                                    <button class="btn btn-outline-success btn-block ms-auto btn-sm" type="submit" name="UpdateContestant" id="UpdateContestant" style="text-decoration:none; -bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;">Update</button>
                                </div>
                    </form>
                <?php 
            }
        }
    }




//criteria delete
if(isset($_POST['criteriaDeleteCode'])){

    $criteriaDeleteCode = $_POST['criteriaDeleteCode'];
    ?>
    <form action="../tri.super/superCode.php" method="POST">
        <div class="row mb-3">

            <input type="hidden" name="deleteCode" value="<?=$criteriaDeleteCode?>"/>
            <div class="col-sm-12 mb-1 mt-1">
                <h3 align="center"><p class="text-warning">Are you sure you want to Delete?</p></h3>
            </div>

        </div>
                <div><hr class="dropdown-divider"/></div>

                <div class="mt-3 mb-0 d-flex bd-highlight" align="center">
                    <button class="btn btn-outline-danger btn-sm me-2" type="submit" name="submitDeleteCriteria" id="submitDeleteCriteria" style="text-decoration:none; -bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem; margin-left: 180px;">Delete</button>
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                </div>
    </form>
<?php 
}


// update User
if(isset($_POST['updateCode'])) {

    $updateCode = $_POST['updateCode'];
    $updateUpdatedBy = $_POST['updateUpdatedBy'];

    $updateQuery = "SELECT * FROM user WHERE code = ?";
    $stmt = $db->prepare($updateQuery);
    $stmt->bind_param("s", $updateCode);
    $stmt->execute();
    $resultUpdate = $stmt->get_result();

        // Check if there are rows in the result set
        if ($resultUpdate->num_rows > 0) {
            // Loop through each row
            while ($rowUpdate = mysqli_fetch_assoc($resultUpdate)) {
?>

    <form action="superCode.php" method="POST">
        <div class="row mb-3">
                <input type="hidden" name="updateCode" value="<?= $rowUpdate['code']?>"/>
                <input type="hidden" name="updatedBy" value="<?=$updateUpdatedBy?>"/>
                <div class="col-md-3 mb-3 mt-2">
                    <div class="form-floating">
                        <input class="form-control" id="username" name="username" type="text" value="<?= $rowUpdate['username']?>" data-maxlength="45" maxlength="45" required/>
                        <label for="Username">Username</label>
                    </div>
                </div>
                
                <div class="col-md-3 mb-3 mt-2">
                    <div class="form-floating">
                        <input class="form-control" id="password" name="password" type="text" value="<?= $rowUpdate['password']?>" data-maxlength="45" maxlength="45" required/>
                        <label for="Password">Password</label>
                    </div>
                </div>
                <div class="col-md-3 mb-3 mt-2">
                    <div class="form-floating">
                        <input class="form-control" id="name" name="name" type="text" value="<?= $rowUpdate['name']?>" data-maxlength="45" maxlength="45" required/>
                        <label for="criteriaName">Name</label>
                    </div>
                </div>
                <div class="col-md-3 mb-3 mt-2">
                    <div class="form-floating">
                        <select class="form-select p-3" id="type" name="type" required>
                            <option value="" selected disabled>~Select Account Type~</option>
                            <option value="isSuper" <?php echo ($rowUpdate['types'] == "isSuper") ? 'selected' : '' ?> >Super User</option>
                            <option value="isAdmin" <?php echo ($rowUpdate['types'] == "isAdmin") ? 'selected' : '' ?> >Administrator</option>
                        </select>
                    </div>
                </div>
        </div>
            <div><hr class="dropdown-divider"/></div>
                <div class="mt-3 mb-0 d-flex bd-highlight">
                    <button class="btn btn-outline-success btn-block ms-auto btn-sm" type="submit" name="updateUser" id="updateUser" style="text-decoration:none; -bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;">Submit</button>
                </div>
    </form>

<?Php
        }
    }
}


//Settings update
if(isset($_POST['updateSettingCode'])){
    $updateSettingCode = $_POST['updateSettingCode'];
    
    $updateQuery = settingViewList;
    $stmt = $db->prepare($updateQuery);
    $stmt->bind_param("s", $updateSettingCode);
    $stmt->execute();
    $resultUpdate = $stmt->get_result();

        // Check if there are rows in the result set
        if ($resultUpdate->num_rows > 0) {
            // Loop through each row
            while ($rowUpdate = mysqli_fetch_assoc($resultUpdate)) {
    ?>
                    <form action="../tri.super/superCode.php" method="POST" enctype="multipart/form-data">
                        <div class="row mb-3">
                        <input type="hidden" name="updateSettingCode" value="<?=$rowUpdate['id']?>"/>
                                <div class="col-sm-4 mb-3">
                                    <div class="form-floating">
                                        <input class="form-control" id="settingPageantName" name="settingPageantName" type="text" value="<?= $rowUpdate['pageant_name'] ?>" placeholder="" data-maxlength="255" maxlength="255" required/>
                                        <label for="PageantName">Pageant Name</label>
                                    </div>
                                </div>
                                
                                <div class="col-sm-4 mb-3">
                                    <div class="form-floating">
                                        <input class="condition filter form-control" id="settingCondition" name="settingCondition" type="text" value="<?= $rowUpdate['condition_final'] ?>" placeholder="" data-maxlength="4" maxlength="4" required/>
                                        <label for="ConditiontoFinalist">Condition to Finalist</label>
                                    </div>
                                </div>

                                <div class="col-sm-4 mb-3">
                                    <div class="form-floating">
                                        <?php $selected_Status = $rowUpdate['isGeneral']; ?>
                                        <select class="form-select" id="settingStatus floatingSelectGrid" name="settingStatus" required>
                                            <option value="" selected disabled>Select Status</option>
                                            <option value="0" <?= $selected_Status == 0 ? "selected" : "" ?>>WITH CATEGORY</option>
                                            <option value="1" <?= $selected_Status == 1 ? "selected" : "" ?>>GENERAL</option>
                                        </select>
                                        <label for="PageantStatus">Pageant Status</label>
                                    </div>
                                </div>

                                <div class="col-sm-4 mb-3">
                                    <div class="form-floating">
                                        <?php $selected_Weighted_scoring = $rowUpdate['weighted_scoring']; ?>
                                        <select class="form-select" id="settingWeightedScoring floatingSelectGrid" name="settingWeightedScoring" required>
                                            <option value="" selected disabled>Select Weighted Scoring</option>
                                            <option value="0" <?= $selected_Weighted_scoring == 0 ? "selected" : "" ?>>Point System</option>
                                            <option value="1" <?= $selected_Weighted_scoring == 1 ? "selected" : "" ?>>Percentage System</option>
                                        </select>
                                        <label for="PageantStatus">Pageant Weighted Scoring<</label>
                                    </div>
                                </div>

                                <div class="col-sm-4 mb-3">
                                    <label for="formFile" class="form-label">Logo</label>
                                    <input class="form-control" id="formFile" name="settingLogo" type="file"/>
                                </div>

                                <div class="col-sm-4 mb-3">
                                    <label for="CoverPhoto" class="form-label">Cover Photo</label>
                                    <input class="form-control" id="formFile" name="settingCoverPhoto" type="file"/>    
                                </div>


                        </div>
                            
                            <div class="mt-3 col-12">
                                <button class="btn btn-success btn-sm w-100" type="submit" name="addsettings" id="addsettings">Update</button>
                            </div>
                            <div class="my-4"><hr class="dropdown-divider"/></div>
                    </form>

                    <div class="row text-center align-items-center">
                        <div class="col-sm-6 mb-3">
                            <p>Preview Logo:</p><img id="previewLogo" src="../assets/img/<?=$rowUpdate['logo']; ?>" style="width: 6.5rem; height: 6.5rem;" alt="Progam Logo">
                        </div>

                        <div class="col-sm-6 mb-3">
                            <p>Preview Cover Photo:</p><img id="previewCoverPhoto" src="../assets/img/<?=$rowUpdate['cover_photo']; ?>" class="rounded" style="width: 10.5rem; height: 6.5rem;" alt="Progam Logo">
                        </div>
                    </div>
                                      
                    
                <?php 
            }
        }
    }

//judge update
if(isset($_POST['updateJudgeCode'])) {
    $updateJudgeCode = $_POST['updateJudgeCode'];
    $updateUpdatedBy = $_POST['updateUpdatedBy'];

    $updateQuery = updateViewJudge;
    $stmt = $db->prepare($updateQuery);
    $stmt->bind_param("s", $updateJudgeCode);
    $stmt->execute();
    $resultUpdate = $stmt->get_result();

        // Check if there are rows in the result set
        if ($resultUpdate->num_rows > 0) {
            // Loop through each row
            while ($rowUpdate = mysqli_fetch_assoc($resultUpdate)) {
    ?>
                    <form action="../tri.super/superCode.php" method="POST">
                        <div class="row mb-3">
                        <input type="hidden" name="updateJudgeCode" value="<?=$rowUpdate['code']?>"/>
                        <input type="hidden" name="updatedBy" value="<?=$updateUpdatedBy?>"/>
                        
                                <div class="col-sm-12 mb-3">
                                    <div class="form-floating">
                                        <input class="form-control" id="updateJudgeUsername" name="updateJudgeUsername" type="text" value="<?= $rowUpdate['username'] ?>" placeholder="" data-maxlength="255" maxlength="255" required/>
                                        <label for="label">User Name</label>
                                    </div>
                                </div>
                                <div class="col-sm-12 mb-3">
                                    <div class="form-floating">
                                        <input class="form-control" id="updateJudgePassword" name="updateJudgePassword" value="<?= $rowUpdate['password'] ?>" type="text" placeholder="" data-maxlength="4" maxlength="4" required/>
                                        <label for="label">Password</label>
                                    </div>
                                </div>
                                <div class="col-sm-12 mb-3">
                                    <div class="form-floating">
                                        <input class="form-control" id="updateJudgeName" name="updateJudgeName" value="<?= $rowUpdate['name'] ?>" type="text" placeholder="" data-maxlength="255" maxlength="255" required/>
                                        <label for="label">Name</label>
                                    </div>
                                </div>

                                <div class="col-sm-12 mb-3">
                                    <div class="form-floating">
                                    <select class="form-select" id="updateJudgeCategoryType" name="updateJudgeCategoryType" required>
                                    <option value="" disabled>~Select Category~</option>
                                    <option value="FE" <?php echo ($rowUpdate['category'] == "FE") ? 'selected' : ''; ?>>
                                        Female
                                    </option>
                                    <option value="MA" <?php echo ($rowUpdate['category'] == "MA") ? 'selected' : ''; ?>>
                                        Male
                                    </option>
                             <option value="B" <?php echo ($rowUpdate['category'] == "B") ? 'selected' : ''; ?>>
                                 Both Female/Male
                             </option>
                                    <option value="LGBTQ-LES" <?php echo ($rowUpdate['category'] == "LGBTQ-LES") ? 'selected' : ''; ?>>
                                        Lesbian
                                    </option>
                                    <option value="LGBTQ-GAY" <?php echo ($rowUpdate['category'] == "LGBTQ-GAY") ? 'selected' : ''; ?>>
                                        Gay
                                    </option>
                             <option value="LGBTQ-B" <?php echo ($rowUpdate['category'] == "LGBTQ-B") ? 'selected' : ''; ?>>
                                 Lesbian/Gay (Both)
                             </option>
                                </select>

                                        <label for="input">Category Type</label>
                                    </div>
                                </div>

                            <div><hr class="dropdown-divider"/></div>
                                <div class="mt-3 mb-0 d-flex bd-highlight">
                                    <button class="btn btn-outline-success btn-block ms-auto btn-sm" type="submit" name="updateJudge" id="updateJudge" style="text-decoration:none; -bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;">Update</button>
                                </div>
                    </form>
                <?php 
            }
        }

}

if(isset($_POST['updateGenCode'])) {
    $updatecode = $_POST['updateGenCode'];
    $selectedEvent = $_POST['selectedEvent'];
    $selectedJudge = $_POST['selectedJudge'];

    $updateJudgeScoreQuery = judgeScoreUpdate;
    $stmt = $db->prepare($updateJudgeScoreQuery);
    $stmt->bind_param("sss", $updatecode, $selectedJudge, $selectedEvent);
    $stmt->execute();
    $resultUpdateJudgeScore = $stmt->get_result();
    

    $eventCriteriaQuery = criteriaList;
    $stmt = $db->prepare($eventCriteriaQuery);
    $stmt->bind_param("s", $selectedEvent);
    $stmt->execute();
    $resultEventCriteria = $stmt->get_result();

    if ($resultEventCriteria->num_rows <= 0) {
        echo "<h4 align='center'>No Data Found</h4>";
        exit;
    }

    $contestantSelectedQuery = contestantListToUpdate;
    $stmt = $db->prepare($contestantSelectedQuery);
    $stmt->bind_param("s", $updatecode);
    $stmt->execute();
    $resultEvents = $stmt->get_result();
    $fetchResultEventSelected = $resultEvents->fetch_assoc();


    $scoreToUpdate = '';

        if($fetchResultEventSelected != NULL){
            $scoreToUpdate .= '<h3 class="mt-4 text-muted selected" align="center">Candidate Number: '.$fetchResultEventSelected['sequence'].'</h3>';
        } else {
            $scoreToUpdate .= '<h3 class="mt-4 text-muted" align="center"></h3>';
        }

            $scoreToUpdate .= '
                <div class="card-body table-responsive-sm">
                    <table class="table table-hover" id="data">
                        <thead>
                            <tr>';

            while ($eventCriteriaResult = $resultEventCriteria->fetch_assoc()) {
                $criteriaHeader = $eventCriteriaResult['criteria_name'];
                $criteriaHeaderPercent = $eventCriteriaResult['percent'];
                $scoreToUpdate .= ' 
                                <th>
                                    <div class="small ms-3 me-3" align="center">'.$criteriaHeader.'('.$criteriaHeaderPercent.')</div>
                                </th>';
            }

                $scoreToUpdate .= '
                            </tr>
                        </thead>
                        <tbody>
                            <tr>';

                            if ($resultUpdateJudgeScore->num_rows > 0) {
                                foreach ($resultUpdateJudgeScore as $judgeEventScoreCode) {
                                    $judgeEventScoreUpdateCode = $judgeEventScoreCode['code'];
                $scoreToUpdate .= '
                                <input type="hidden" name="updateEventScoreCode[]" value="'. $judgeEventScoreUpdateCode.'" />
                            ';
                                }
                            }
                        
                            if ($resultUpdateJudgeScore->num_rows > 0) {
                                foreach ($resultUpdateJudgeScore as $judgeScoreUpdateResult) {
                                    $judgeScoreToUpdate = $judgeScoreUpdateResult['score'];
                                    $judgeUpdateCriteriaCode = $judgeScoreUpdateResult['criteria_code'];

                                    //fetch criteria percentage
                                    $criteriaPercentSelectedQuery = criteriaPercentUpdate;
                                    $stmt = $db->prepare($criteriaPercentSelectedQuery);
                                    $stmt->bind_param("s", $judgeUpdateCriteriaCode);
                                    $stmt->execute();
                                    $resultEvents = $stmt->get_result();
                                    $fetchResultEventCriteriaUpdateSelected = $resultEvents->fetch_assoc();
                        
                $scoreToUpdate .= '
                                    
                                    <td>
                                        <div class="col-lg-12">
                                            <input type="text" name="updateScore[]" class="judge form-control" value="'. $judgeScoreToUpdate .'" placeholder="Enter in Decimal" maxlength="5" required data-percent="'.$fetchResultEventCriteriaUpdateSelected['percent'].'" />
                                        </div>
                                    </td>
                                    ';

                                }
                            }
                        if (!empty($judgeEventScoreUpdateCode) && ($judgeScoreToUpdate ?? 0) != 0) {
                $scoreToUpdate .= '
                                <td class="col-sm-2" style="width: 185px">
                                    <button data-updateScoreCode = "'. ($judgeEventScoreUpdateCode) .'" data-updateEventScore = "'. $judgeScoreToUpdate .'" class="updatedScoreCode btn btn-outline-success btn-sm mt-1 rounded">Update</button>
                                </td>';
                        }
                        else{
                $scoreToUpdate .= '
                            <td class="col-sm-2" style="width: 185px">
                               
                            </td>';
                        }
                $scoreToUpdate .= '
                            </tr>';

                $scoreToUpdate .= '
                        </tbody>
                    </table>
                </div>';

        
    echo $scoreToUpdate;
}

?>

<script>

// Update Score button click event
$('.updatedScoreCode').on('click', function() {
    var $tr = $(this).closest('tr');

    var updateEventScoreCodes = $tr.find('input[name="updateEventScoreCode[]"]').map(function() {
        return $(this).val();
    }).get();

    var updateScores = $tr.find('input[name="updateScore[]"]').map(function() {
        return $(this).val();
    }).get();

    if (!isValidInput(updateScores)) {
        Swal.fire({
            title: 'Please Fill in the Field!',
            icon: 'warning',
            timer: 1800,
            showConfirmButton: false,
            timerProgressBar: true
        });
        return;
    }

    // Ensure that scores and eventScoreCodes are sent as arrays
    var formData = new FormData();
    formData.append('updateEventScoreCodes', JSON.stringify(updateEventScoreCodes));
    formData.append('updateScores', JSON.stringify(updateScores));

    $.ajax({
        type: 'POST',
        url: '../tri.admin/adminCode.php',
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            Swal.fire({
                icon: 'success',
                title: 'Score Updated! Refresh the Page to see the Result!!',
                toast: true,
                position: 'top-end',
                timer: 3000,
                showConfirmButton: false,
                timerProgressBar: true
            });
        },
        error: function(error) {
            console.error(error);
        }
    });
});

function isValidInput(updateScores) {
    // Check if any score is empty or not a valid number
    return updateScores.every(score => score.trim() !== '' && !isNaN(score));
}

</script>

