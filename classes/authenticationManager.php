<?php

class authentication {

	private $executeRequest;
	CONST STORE_USER = 'INSERT INTO users(unique_id, name, encrypted_password, salt, created_at, idService)
                            VALUES(:unique_id, :name, :encrypted_password, :salt, NOW(), :idService)';
	CONST UPDATE_USER = 'UPDATE users 
						SET encrypted_password = :encrypted_password ,
							salt = :salt,
							updated_at = NOW()
						WHERE uid = :uid';
	CONST SELECT_USER_BY_UID = 'SELECT * FROM users WHERE uid = :uid';
	CONST SELECT_USER_BY_NAME_PASSWORD = 'SELECT * FROM users WHERE name = :name';
	CONST SELECT_USER_BY_NAME = 'SELECT name from users WHERE name = :name';
	CONST SELECT_USER_SERVICE = 'SELECT idService, nomService FROM service WHERE idService =:idService';
	CONST SQL_SELECT_ALL_ACCOUNT = 'SELECT uid, name, created_at, updated_at, nomService
			FROM users, service
			WHERE users.idService = service.idService';

/*********************BEGIN DECLARE PUBLIC & PRIVATE********************/
	private $pdoStatement;
	
	public $data;
	public $pdoQuery;
	
/*********************END DECLARE********************/
    // constructor
    function __construct() {
		date_default_timezone_set('GMT');
		$this->pdoQuery = new PdoExecuteQuery();
    }
	
	private function isFormSubmit($formname){
		return (isset($_POST['formname']) && ($_POST['formname'])==$formname);
	}

	private function isDateFormat($formatInitial, $formatFinal, $string)
	{
		$date = date_create_from_format($formatInitial, $string);
		$date = !empty($date) ? date_format($date, $formatFinal) : '';
		return   $date;
	}
		
    /**
     * Storing new user
     * returns user details
     */
    public function storeUser() 
       {
	if ($this->isFormSubmit('register') && !empty($_POST['name']) && !empty($_POST['password'])){
            $formValidation = new FormFieldValidation();
            unset($_POST['formname']);
            unset($_POST['submit']);
            $name = strip_tags($_POST['name']);
            if (!$this->isUserExisted($name)){
                    $formValidation->setDataFilter(array(
                                    'unique_id' => FILTER_DEFAULT,
                                    'name' => FILTER_DEFAULT,
                                    'encrypted_password' => FILTER_DEFAULT,
                                    'salt' => FILTER_DEFAULT,
                                    'idService' => FILTER_VALIDATE_INT,
                        ));
                    $uuid = uniqid('', true);
                    $hash = $this->hashSSHA($_POST['password']);
                    $encrypted_password = $hash["encrypted"]; // encrypted password
                    $salt = $hash["salt"]; // salt	

                    $data = array(
                                    'unique_id' => $uuid,
                                    'name' => $_POST['name'],
                                    'encrypted_password' => $encrypted_password,
                                    'salt' => $salt,
                                    'idService' => (int)$_POST['idService'],
                    );
                  //  unset($_POST['password']);
                    $data = $formValidation->getFilteredData($data);
                   // var_dump($data);
                    $result = $this->pdoQuery->executePdoQuery(self::STORE_USER, $data);
                    // check for successful store
                    if ($result) {
                        // get user details 
                             $uid = $this->pdoQuery->getLastInserId();
                            $params = array(
                                            'uid' => $uid
                            );
                            $result = array(
                                            'error' => 0,
                                            'type' => 'success',
                                            'info' => 'L\'utilisateur a été ajouté avec succès ',
                                            'data' => $this->pdoQuery->executePdoSelectQueryTable(self::SELECT_USER_BY_UID, $params)
                            );
                         //   var_dump($result);
                        // return user details
                        return $result;
                    } else {
                            $result = array(
                                            'error' => 1,
                                            'type' => 'danger',
                                            'info' => 'L\'opération a échoué'
                            );
                        return $result;
                    }
            }else {
                    $result = array(
                                    'error' => 1,
                                        'type' => 'warning',
                                    'info' => 'L\'utilisateur existe déjà'
                    );
                    return $result;
                    }
        }else {
                $result = array(
                                'error' => 1,
                                'type' => 'warning',
                                'info' => 'Veuillez remplir correctement tous les champs'
                );
                return $result;
                    }
    }

    /**
     * Get user by email and password
     */
    public function getUserByNameAndPassword() 
    {
	if ($this->isFormSubmit('login') && !empty($_POST['name']) && !empty($_POST['password'])){
                $formValidation = new FormFieldValidation();
                unset($_POST['formname']);
                unset($_POST['submit']);
                $formValidation->setDataFilter(array(
                                'name' => FILTER_DEFAULT,
                ));
                $data = array(
                                'name' => $_POST['name'],
                );

                $data = $formValidation->getFilteredData($data);
                $result = $this->pdoQuery->executePdoSelectQueryTable(self::SELECT_USER_BY_NAME_PASSWORD, $data);
                // check for result 
                $no_of_rows = sizeOf($result);
                if ($no_of_rows > 0) {
                    $result = $result;
                    $salt = $result[0]['salt'];
                    $encrypted_password = $result[0]['encrypted_password'];
                    $hash = $this->checkhashSSHA($salt, $_POST['password']);
                    $idService = $result[0]['idService'];
                    // check for password equality
                    if ($encrypted_password == $hash) {
                    	$role = $this->pdoQuery->executePdoSelectQueryTable(self::SELECT_USER_SERVICE, array(
                                'idService' => $idService,
                ));
//                     	var_dump($role); die();
                        // user authentication details are correct
                            $data = array(
                                            'error' => 0,
                                            'type' => 'success',
                                            'info' => 'connexion éffectué avec succès',
                                            'data' => $result
                            );
                         $_SESSION['CREDIALS'] = $result[0];
                         $_SESSION['CONNECTED'] = true;
                         $_SESSION['nomService'] = $role[0]['nomService'];
                         $_SESSION['idService'] = $role[0]['idService'];
                          
                        $loginManager = new loginManager();
                        $loginManager->checkLogin('','');
                       //var_dump($data);
                        return $data;
                    }else {
                        // user authentication details are incorrect
                                $data = array(
                                                'error' => 1,
                                                'type' => 'danger',
                                                'info' => 'login ou mot de passe incorrecte'
                                );
                                return $data;
                        }
                } else {
                    // user not found
                            $data = array(
                                            'error' => 1,
                                            'type' => 'warning',
                                            'info' => 'Ce compte n\'existe pas'
                            );
                    return $data;
                }
        }else {
                    // invalid parameters
                            $data = array(
                                            'error' => 1,
                                            'type' => 'warning',
                                            'info' => 'Veuillez remplir correctement tous les champs'
                            );
                    return $data;
                }
    }

    /**
     * Check user is existed or not
     */
    public function isUserExisted($name) {
		$params = array(
				'name' => $name
		);
		$result = $this->pdoQuery->executePdoSelectQueryTable(self::SELECT_USER_BY_NAME, $params);
        $no_of_rows = sizeOf($result);
        if ($no_of_rows > 0) {
            // user existed 
            return true;
        } else {
            // user not existed
            return false;
        }
    }

    /**
     * Encrypting password
     * @param password
     * returns salt and encrypted password
     */
    public function hashSSHA($password) {

        $salt = sha1(rand());
        $salt = substr($salt, 0, 10);
        $encrypted = base64_encode(sha1($password . $salt, true) . $salt);
        $hash = array("salt" => $salt, "encrypted" => $encrypted);
        return $hash;
    }

    /**
     * Decrypting password
     * @param salt, password
     * returns hash string
     */
    public function checkhashSSHA($salt, $password) {

        $hash = base64_encode(sha1($password . $salt, true) . $salt);

        return $hash;
    }
	
	
    public function updateUser() 
       {
	if ($this->isFormSubmit('updateUser') && !empty($_POST['name']) && !empty($_POST['uid']) && !empty($_POST['old_password']) && isset($_POST['password'])){
            $formValidation = new FormFieldValidation();
            unset($_POST['formname']);
            unset($_POST['submit']);
            $name = strip_tags($_POST['name']);
			$param = array('name' => $name);
			$oldData = $this->pdoQuery->executePdoSelectQueryTable(self::SELECT_USER_BY_NAME_PASSWORD, $param);
            if ($this->isUserExisted($name) && sizeOf($oldData)>0){
                    $formValidation->setDataFilter(array(
                                    'encrypted_password' => FILTER_DEFAULT,
                                    'salt' => FILTER_DEFAULT,
                                    'uid' => FILTER_DEFAULT,
                        ));
                    $hash = $this->hashSSHA($_POST['password']);
					//get BD pass info
					$BDsalt = $oldData[0]['salt'];
                    $BDPass = $oldData[0]['encrypted_password'];
					// encrypt old password with the bd salt
                    $encrypted_old_password = $this->checkhashSSHA($BDsalt, $_POST['old_password']);
					/*
					var_dump($BDPass);
					var_dump($encrypted_old_password);
					var_dump($hash["encrypted"]); */
                    // check for password equality
					if($encrypted_old_password == $BDPass){
							
						$encrypted_password = $hash["encrypted"]; // encrypted password
						$salt = $hash["salt"]; // salt	

						$data = array(
										'encrypted_password' => $encrypted_password,
										'salt' => $salt,
										'uid' => (string)$_POST['uid'],
						);
						$data = $formValidation->getFilteredData($data);
					//    var_dump($data);
						$result = $this->pdoQuery->executePdoQuery(self::UPDATE_USER, $data);
					//    var_dump($result);
						
						// check for successful store
						if ($result) {
								$result = array(
												'error' => 0,
												'type' => 'success',
												'info' => "Le compte a été mis à jour avec succès ",
												
								);
							 //   var_dump($result);
							// return user details
							return $result;
						} else {
								$result = array(
												'error' => 1,
												'type' => 'danger',
												'info' => "L'opération a échoué"
								);
							return $result;
						}
					} else {
								$result = array(
												'error' => 1,
												'type' => 'danger',
												'info' => "Désolé! L'ancien mot de passe est incorrecte"
								);
							return $result;
						}
            }else {
                    $result = array(
                                    'error' => 1,
                                        'type' => 'warning',
                                    'info' => "Le compte n'existe pas"
                    );
                    return $result;
                    }
        }else {
                $result = array(
                                'error' => 1,
                                'type' => 'warning',
                                'info' => 'Veuillez remplir correctement tous les champs'
                );
                return $result;
                    }
    }

	
	public function displayAccount()
	{
		$content='';
		$result = $this->pdoQuery->executePdoSelectQueryTable(self::SQL_SELECT_ALL_ACCOUNT, array(''));
		$nb = sizeOf($result);
		if($nb>0){
			$content .= '<div class="row">
								<div class="col-xs-12">
									<div class="box ">
										<div class="box-header">
											<i class="fa fa-folder"></i>
											<h3 class="box-title">Liste des comptes</h3>
											<div class="pull-right box-tools">
												<button class="btn btn-info btn-sm" data-widget="collapse" data-toggle="tooltip" title="Afficher/Masquer"><i class="fa fa-minus"></i></button>
												<button class="btn btn-info btn-sm" data-widget="remove" data-toggle="tooltip" title="Fermer"><i class="fa fa-times"></i></button>
											</div>
										</div>
									<div class="box-body">
								<table id="gridAffaire" class="table table-bordered table-striped gridAffaire">
					<thead>
					<tr>
						<th>Utilisateur</th>
						<th>Service</th>
						<th>Créé le ...</th>
						<th>Modifié le ...</th>
						<th>opération</th>
						</tr>';
						$content.='</thead>
						<tbody>';
				foreach ($result as $data){
				$content.= '<tr>'.
						'<td>' . $data['name'] . '</td>'.
						'<td>' . $data['nomService'] . '</td>'.
						'<td>' . $this->isDateFormat('Y-m-d H:i:s', 'd-m-Y H:i:s',$data['created_at']) . '</td>'.
						'<td>' . $this->isDateFormat('Y-m-d H:i:s', 'd-m-Y H:i:s',$data['updated_at']). '</td>'.
						'<td><a href="index.php?p=register&id='.$data['uid'].'&is='.$data['name'].'"><span class="label label-success">Changer le mot de passe</span></a></td>'.
						'</tr>';
			}
			$content .='
				</tbody>
					<tfoot>
						<tr>
						<th>Utilisateur</th>
						<th>Service</th>
						<th>Créé le ...</th>
						<th>Modifié le ...</th>
						<th>opération</th>
						</tr>';
					$content.='</tfoot>
				</table>
				</div></div></div></div>';
		}
		else {
			$content .='<div class="alert alert-info alert-dismissable"><i class="icon fa fa-info-circle"></i> Aucune liste disponible</div>';
		}
		return $content;
	}


}

?>