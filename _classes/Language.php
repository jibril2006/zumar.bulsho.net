<?php

class Language {

    private $UserLng;
    private $langSelected;
    public $lang = array();


    public function __construct($userLanguage){

        $this->UserLng = $userLanguage;
    }

    public function userLanguage(){

        switch($this->UserLng){
            /*
            ------------------
            Language: English
            ------------------
            */
          
            case "en":
                $lang['PAGE_TITLE'] = ' JSF-System';
                $lang['PAGE_TITLE_LOGIN'] = 'JSF-SYSTEM LOGIN';
                $lang['HEADER_TITLE'] = 'JSF-SYSTEM';
                $lang['SITE_NAME'] = 'JSF-SYSTEM';
                $lang['SLOGAN'] = ' ';
                $lang['HEADING'] = 'Heading';
                $lang['THIS_SITE'] = 'www.jmbro.com';
                
                $lang['YES'] = 'Yes';
                $lang['NO'] = 'No';
                $lang['REST'] = 'Rest';
                
                $lang['BALANCEDK'] = 'Balance DK';
                $lang['BALANCEDUBAI'] = 'Balance Dubai ';
                $lang['ONTRANSFER'] = 'On transfer';
								
								// TOP MENU
                $lang['SITES'] = 'Sites';
                $lang['BANKING'] = 'Banking';
                $lang['AGENT'] = 'Agent';
                $lang['LANGUAGE'] = 'Language';
                $lang['ENGLISH'] = 'English';
                $lang['SOMALI'] = 'Somali';
                $lang['RECORDS'] = 'Records';
                $lang['CURRENCY'] = 'Currency';
                $lang['PROFILE'] = 'Profile';
                $lang['CHANGE_PASSWORD'] = 'Change password';
                $lang['LOGOUT'] = 'Logout';
                $lang['TOP_VALUTA'] = 'USD Valuta';
                $lang['RATE_IN'] = '$ rate in';
                $lang['RATE_OUT'] = '$ rate out';
                
                $lang['YOUR_RATE_IN'] = 'Your rate in value';
                $lang['YOUR_RATE_OUT'] = 'Your rate out value';
                
                // Menu
                $lang['MENU_LOGIN'] = 'Login';
                $lang['MENU_SIGNUP'] = 'Sign up';
                $lang['MENU_FIND_RIDE'] = 'Find Ride';
                $lang['MENU_ADD_RIDE'] = 'Add Ride';
                $lang['MENU_LOGOUT'] = 'Logout';
                
                // Login
                $lang['EDIT'] = 'Edit';
                $lang['DEL'] = 'Del';
                $lang['DELETE'] = 'Delete';
                $lang['UPDATE'] = 'Update';
                
                
                // Login
                $lang['USERNAME'] = 'Username';
                $lang['PASSWORD'] = 'Password';
                $lang['LOGIN'] = 'Login';
                $lang['REMEMBER_ME'] = 'Remember me';
                $lang['COPYRIGHT_FOOTER'] = 'Copyright &copy; Dulqaad.com 2014 - Licensed to dhoofinter.com';
                
                $lang['PRINT_TOP'] = '';
                $lang['PRINT_CTOP'] = '';
                $lang['PRINT_CFOOTER'] = '';
                $lang['PRINT_FOOTER'] = '';

                
                
                $lang['CLOSE'] = 'Close';
                $lang['CUSTOMERS'] = 'Customers';
                $lang['NATIONALBANK_USD'] = 'Nationalbank USD';
                $lang['YOUR_DKK_USD_VALUTA'] = 'Your DKK USD Valuta';
                $lang['SAVE'] = 'Save';
                $lang['CANCEL'] = 'Cancel';
                $lang['CURRENT_PASSWORD'] = 'Current password';
                $lang['CHOOSE_PASSWORD'] = 'Choose password';
                $lang['TYPE_PASSWORD_AGAIN'] = 'Type password again';
                $lang['CHANGE_PASSWORD'] = 'Change password';
                $lang['PASSWORD_AGAIN'] = 'Password again';
                $lang['NEW_PASSWORD'] = 'New password';
                
                $lang['CHANGE_YOUR_PASSWORD'] = 'Change your password';
                $lang['STATUS'] = 'Status';
                $lang['LIST_OF_USERS'] = 'List of users';
                $lang['LIST_OF_AGENTS'] = 'List of agents';
                
                $lang['NEW_USER'] = 'New user';
                $lang['NEW_AGENT'] = 'New agent';
                $lang['NEW_CUSTOMER'] = 'New customer';
                $lang['FNAME'] = 'Firstname';
                $lang['LNAME'] = 'Lastname';
                $lang['COMPANY'] = 'Company';
                $lang['NAME'] = 'Name';
                $lang['EMAIL'] = 'Email';
                $lang['LASTLOGIN'] = 'Lastlogin';
                $lang['CHOOSE_PASSWORD_AGAIN'] = 'Choose password again';
                $lang['ADD_USER'] = 'Add User';
                $lang['ADD_NEW_USER'] = 'Add New User';
								
								$lang['USER_RIGHTS'] = 'User rights';
								$lang['P_USERRIGHTS'] = 'User rights';
								
                $lang['ADD_AGENT'] = 'Add Agent';
                $lang['ADD_CUSTOMER'] = 'Add Customer';
                $lang['ADD_NEW_AGENT'] = 'Add New Agent';
                $lang['ADD_NEW_MANAGER'] = 'Add New Manager';
                $lang['ADD_NEW_CUSTOMER'] = 'Add New Customer';
                $lang['AGENTID'] = 'Agent ID';
                $lang['CUSTOMERID'] = 'CUSTOMER ID';
                $lang['OWNER'] = 'Owner';
                $lang['TLF'] = 'Tlf';
                $lang['ADDRESS'] = 'Address';
                $lang['NOTE'] = 'Note';
                $lang['FROMDATE'] = 'From date';
                $lang['TODATE'] = 'To date';
                
                $lang['ACTION'] = 'ACTION';
                $lang['LAST_LOGIN'] = 'LAST LOGIN';
                $lang['JOINED'] = 'Joined';
                $lang['SEARCH'] = 'Search';
                $lang['GO'] = 'Go';
                $lang['SET_VALUTA'] = 'Set Valuta';
                $lang['USERS'] = 'Users';
                $lang['AGENTS'] = 'Agents';
                $lang['SETTINGS'] = 'Settings';
                $lang['SESSIONTIMEOUT'] = 'Session timeout';
                $lang['CREDIT_LIMIT'] = 'Credit limit';
                $lang['SITENAME'] = 'Site Name';
                
                
                // Page names
                $lang['P_SITES'] = 'Sites';
                $lang['P_BANKING'] = 'Banking Managing Menu';
                $lang['P_AGENT'] = 'Agent Managing Menu';
                $lang['P_USERS'] = 'List of login Users';
                $lang['P_CUSTOMERS'] = 'Customers';
                $lang['P_AGENTS'] = 'Manage Agents';
                $lang['P_AGENTSETTINGS'] = 'Settings';
                $lang['P_DEPOSIT'] = 'Agents with deposit';
                $lang['P_LOAN'] = 'Agents with loans';
                $lang['P_BALANCE'] = 'Balance overview';
                $lang['P_MANAGER'] = 'Manager accounts';
                
                
                // Transactions
                $lang['DATE']= 'Date';
								$lang['TYPE'] = 'Type';
								$lang['INFO'] = 'Info';
								$lang['REMARK'] = 'Remark';
								$lang['DEBIT'] = 'IN';
								$lang['CREDIT'] = 'OUT';
								$lang['BALANCE'] = 'Balance';
								$lang['ACCOUNT'] = 'Account';
								$lang['WITHDRAW'] = 'Withdraw';
								$lang['TRANSFER'] = 'Transfer';
								$lang['TRANSFERTO'] = 'Transfer to';
								$lang['LOAN'] = 'Loan/withdraw';
								$lang['DEPOSIT'] = 'Deposit';
								$lang['NEWDEPOSIT'] = 'New deposit';
								$lang['EDITDEPOSIT'] = 'Edit deposit';
								$lang['DELDEPOSIT'] = '<span style="color:FF0000;"> Delete deposit !</span>'; 
								$lang['UPDATEDEPOSIT'] = 'Update deposit';
								$lang['NEWLOAN'] = 'New loan/withdraw';
								$lang['EDITLOAN'] = 'Edit loan/withdraw';
								$lang['DELLOAN'] = '<span style="color:FF0000;"> Delete loan/withdraw !</span>';
								$lang['UPDATELOAN'] = 'Update loan/withdraw';
								$lang['UPDATETOPPAYMENT'] = 'Update Toppayment';
								$lang['TRANSFER'] = 'Transfer';
								$lang['NEWTRANSFER'] = 'New transfer';
								$lang['EDITTRANSFER'] = 'Edit transfer';
								$lang['UPDATETRANSFER'] = 'Update transfer';
								$lang['DELTRANSFER'] = 'Delete transfer';
								$lang['NEWDEBIT'] = 'New Debit';
								$lang['ADD_DEPOSIT'] = 'Add deposit';
								$lang['UPDATE_DEPOSIT'] = 'Update deposit';
								$lang['UPDATE_TOPPAYMENT'] = 'Update Toppayment';
								$lang['ADD_LOAN'] = 'Add Loan/withdraw';
								$lang['UPDATE_LOAN'] = 'Update Loan/withdraw';
								$lang['DEL_LOAN'] = 'Delete Loan/withdraw';
								$lang['DEL_TOP'] = 'Delete Toppayment';
								$lang['DELTOP'] = 'Delete Toppayment';
								$lang['ADD_TRANSFER'] = 'Transfer';
								$lang['UPDATE_TRANSFER'] = 'Update Transfer';
								$lang['BALANCE'] = 'Balance';
								$lang['MANAGER'] = 'Manager';
								$lang['MANAGERINFO'] = 'Manager information';
								
								
								
								$lang['AMOUNTOFDEPOSIT'] = 'Amount of deposit';
								$lang['AMOUNTOFLOAN'] = 'Amount of loan';
								$lang['AMOUNTOFTRANSFER'] = 'Amount of transfer';
								
								$lang['RATE'] = 'Rate';
								$lang['RATE0'] = 'Rate';
								$lang['RATE1'] = 'Dollar in';
								$lang['RATE2'] = 'Dollar out';
								$lang['RATE3'] = '$ balance';
								$lang['AMOUNT'] = 'Amount';
								$lang['RATEAMOUNT'] = 'Rate amount'; 
								$lang['RATE_PROFIT'] = 'Rate Profit';
								$lang['PCT_PROFIT'] = 'Procent Profit';
								$lang['RATE_BALANCE'] = 'Rate Balance';

								$lang['NEWTRANSFEROTHERS'] = 'Transfer to Agents';
								$lang['NEWTRANSFERMYACCOUNTS'] = 'Transfer to Own';
								$lang['NEWTRANSFEROWN'] = 'Transfer to Own';
								
								$lang['CONNECTED_AGENT'] = 'Connected Agent';
								
								$lang['FROM'] = 'From';
								$lang['RO'] = 'To';
								$lang['CREATED'] = 'Created';
								$lang['ACCOUNTNR'] = 'Account nr.';
								$lang['CREDITLIMIT'] = 'Credit limit';
								$lang['AGENTIDTO'] = 'Transfer to';
								
								$lang['NEWAGENTPAY'] = 'Agent Payment';
								$lang['NEWTOPPAY'] = 'Top Payment';
								$lang['TOPPAYMENT'] = 'Top Payment';
								$lang['PAYNOW'] = 'Pay now';
								// $lang['RO'] = 'To';
								$lang['PROCENT'] = 'Procent';
								$lang['PROFITPROCENT'] = 'Profit procent';
								$lang['RATEPROFIT'] = 'Rate profit';
								
								
								$lang['SHOW_MANAGER'] = 'Show manager';
								$lang['SHOW_AGENTS'] = 'Show agents';
								$lang['SHOW_CUSTOMERS'] = 'Show customers';
								$lang['SHOW_USERS'] = 'Show users';
								$lang['SHOW_SETTINGS'] = 'Show settings';
								$lang['SHOW_BALANCE'] = 'Show balance';

								$lang['AC_DEPOSIT_ADD'] = 'Add deposit';
								$lang['AC_DEPOSIT_EDIT'] = 'Edit deposit';
								$lang['AC_DEPOSIT_DEL'] = 'Delete deposit';
								$lang['AC_LOAN_ADD'] = 'Add loan';
								$lang['AC_LOAN_EDIT'] = 'Edit loan';
								$lang['AC_LOAN_DEL'] = 'Delete loan';
								$lang['AC_TRANSFER_ADD'] = 'Add transfer';
								$lang['AC_TRANSFER_EDIT'] = 'Edit transfer';
								$lang['AC_TRANSFER_DEL'] = 'Delete transfer';
								$lang['AC_TOP_ADD'] = 'Add top payment ';
								$lang['AC_TOP_EDIT'] = 'Edit top payment';
								$lang['AC_TOP_DEL'] = 'Delete top payment';																
								
								$lang['AC_MANAGER_NEW'] = 'Create new manager';
								$lang['AC_MANAGER_EDIT'] = 'Edit manager';
								$lang['AC_MANAGER_DEL'] = 'Delete manager';
								$lang['AC_MANAGER_DEPOSIT_ADD'] = 'Add deposit to manager';
								$lang['AC_MANAGER_DEPOSIT_EDIT'] = 'Edit manager deposit';
								$lang['AC_MANAGER_DEPOSIT_DEL'] = 'Delete manager deposit';
								$lang['AC_MANAGER_LOAN_ADD'] = 'Add loan to manager';
								$lang['AC_MANAGER_LOAN_EDIT'] = 'Edit manager loan';
								$lang['AC_MANAGER_LOAN_DEL'] = 'Delete manager loan';
								$lang['AC_MANAGER_TRANSFER_ADD'] = 'Transfer from manager';
								$lang['AC_MANAGER_TRANSFER_EDIT'] = 'Edit transfer in manager';
								$lang['AC_MANAGER_TRANSFER_DEL'] = 'Delete transfer in manager';
								$lang['AC_MANAGER_TOP_ADD'] = 'Add top manager ';
								$lang['AC_MANAGER_TOP_EDIT'] = 'Edit top in manager';
								$lang['AC_MANAGER_TOP_DEL'] = 'Delete top in manager';


								$lang['AC_AGENTS_NEW'] = 'Create new agent';
								$lang['AC_AGENTS_EDIT'] = 'Edit agent';
								$lang['AC_AGENTS_DEL'] = 'Delete agent';
								$lang['AC_AGENTS_DEPOSIT_ADD'] = 'Add deposit to agent';
								$lang['AC_AGENTS_DEPOSIT_EDIT'] = 'Edit agent deposit';
								$lang['AC_AGENTS_DEPOSIT_DEL'] = 'Delete agent deposit';
								$lang['AC_AGENTS_LOAN_ADD'] = 'Add loan to agent';
								$lang['AC_AGENTS_LOAN_EDIT'] = 'Edit agent loan';
								$lang['AC_AGENTS_LOAN_DEL'] = 'Delete agent loan';
								$lang['AC_AGENTS_TRANSFER_ADD'] = 'Transfer from agent';
								$lang['AC_AGENTS_TRANSFER_EDIT'] = 'Edit transfer in agent';
								$lang['AC_AGENTS_TRANSFER_DEL'] = 'Delete transfer in agent';
								$lang['AC_AGENTS_TOP_ADD'] = 'Add top payment agent ';
								$lang['AC_AGENTS_TOP_EDIT'] = 'Edit top payment in agent';
								$lang['AC_AGENTS_TOP_DEL'] = 'Delete top payment in agent';
									
								$lang['AC_CUSTOMERS_NEW'] = 'Create new customer';
								$lang['AC_CUSTOMERS_EDIT'] = 'Edit customer';
								$lang['AC_CUSTOMERS_DEL'] = 'Delete customer';
								$lang['AC_CUSTOMERS_DEPOSIT_ADD'] = 'Add deposit to customer';
								$lang['AC_CUSTOMERS_DEPOSIT_EDIT'] = 'Edit customer deposit';
								$lang['AC_CUSTOMERS_DEPOSIT_DEL'] = 'Delete customer deposit';
								$lang['AC_CUSTOMERS_LOAN_ADD'] = 'Add loan to customer';
								$lang['AC_CUSTOMERS_LOAN_EDIT'] = 'Edit customer loan';
								$lang['AC_CUSTOMERS_LOAN_DEL'] = 'Delete customer loan';
								$lang['AC_CUSTOMERS_TRANSFER_ADD'] = 'Transfer from customer';
								$lang['AC_CUSTOMERS_TRANSFER_EDIT'] = 'Edit transfer in customer';
								$lang['AC_CUSTOMERS_TRANSFER_DEL'] = 'Delete transfer in customer';
								$lang['AC_CUSTOMERS_TOP_ADD'] = 'Add top payment customer ';
								$lang['AC_CUSTOMERS_TOP_EDIT'] = 'Edit top payment in customer';
								$lang['AC_CUSTOMERS_TOP_DEL'] = 'Delete top payment in customer';
								
								$lang['AC_USERS_NEW'] = 'Create new user';
								$lang['AC_USERS_EDIT'] = 'Edit user';
								$lang['AC_USERS_PASSWORD'] = 'Edit password';
								$lang['AC_USERS_DEL'] = 'Delete user';
								
								$lang['NEWTRANSFERCUSTOMER'] = 'Send to customer';
								
								$lang['TOACCOUNT'] = 'To account';
								$lang['FROMACCOUNT'] = 'From account';
								
								$lang['TO'] = 'To';
								$lang['FROM'] = 'From';
								
								$lang['SEND'] = 'Send';
								$lang['SENDTOCUSTOMER'] = 'Send to customer';
								$lang['EDITSEND'] = 'Edit send ';
								$lang['DELSEND'] = 'Del send';
								
								
								
							
	
								
                
                

                return $lang;
                break;

                /*
                ------------------
                Language: Somalia
                ------------------
                */

            		case "so":

                $lang['PAGE_TITLE'] = ' JSF-System';
                $lang['PAGE_TITLE_LOGIN'] = 'JSF-SYSTEM LOGIN';
                $lang['HEADER_TITLE'] = 'JSF-SYSTEM';
                $lang['SITE_NAME'] = 'JSF-SYSTEM';
                $lang['SLOGAN'] = ' ';
                $lang['HEADING'] = 'Heading';
                $lang['THIS_SITE'] = 'www.jmbro.com';
								
								// TOP MENU
                $lang['SITES'] = 'Beejka';
                $lang['BANKING'] = 'Banking';
                $lang['AGENT'] = 'Agent';
                $lang['LANGUAGE'] = 'Luqad';
                $lang['ENGLISH'] = 'English';
                $lang['SOMALI'] = 'Somali';
                $lang['RECORDS'] = 'Records';
                $lang['CURRENCY'] = 'Currency';
                $lang['PROFILE'] = 'Profile';
                $lang['CHANGE_PASSWORD'] = 'Change password';
                $lang['LOGOUT'] = 'Logout';
                $lang['TOP_VALUTA'] = 'USD Valuta';
                $lang['RATE_IN'] = '$ rate in';
                $lang['RATE_OUT'] = '$ rate out';
                
                $lang['YOUR_RATE_IN'] = 'Your rate in value';
                $lang['YOUR_RATE_OUT'] = 'Your rate out value';
                
                // Menu
                $lang['MENU_LOGIN'] = 'Login';
                $lang['MENU_SIGNUP'] = 'Sign up';
                $lang['MENU_FIND_RIDE'] = 'Find Ride';
                $lang['MENU_ADD_RIDE'] = 'Add Ride';
                $lang['MENU_LOGOUT'] = 'Logout';
                
                // Login
                $lang['EDIT'] = 'Edit';
                $lang['DEL'] = 'Del';
                $lang['DELETE'] = 'Delete';
                $lang['UPDATE'] = 'Update';
                
                
                // Login
                $lang['USERNAME'] = 'Username';
                $lang['PASSWORD'] = 'Password';
                $lang['LOGIN'] = 'Login';
                $lang['REMEMBER_ME'] = 'Remember me';
                $lang['COPYRIGHT_FOOTER'] = 'Copyright &copy; Dulqaad.com 2014 - Licensed to dhoofinter.com';
                
                $lang['PRINT_TOP'] = '';
                $lang['PRINT_CTOP'] = '';
                $lang['PRINT_CFOOTER'] = '';
                $lang['PRINT_FOOTER'] = '';

                
                
                $lang['CLOSE'] = 'Close';
                $lang['NATIONALBANK_USD'] = 'Nationalbank USD';
                $lang['YOUR_DKK_USD_VALUTA'] = 'Your DKK USD Valuta';
                $lang['SAVE'] = 'Save';
                $lang['CANCEL'] = 'Cancel';
                $lang['CURRENT_PASSWORD'] = 'Current password';
                $lang['CHOOSE_PASSWORD'] = 'Choose password';
                $lang['TYPE_PASSWORD_AGAIN'] = 'Type password again';
                $lang['CHANGE_PASSWORD'] = 'Change password';
                $lang['PASSWORD_AGAIN'] = 'Password again';
                $lang['NEW_PASSWORD'] = 'New password';
                
                $lang['CHANGE_YOUR_PASSWORD'] = 'Change your password';
                $lang['STATUS'] = 'Status';
                $lang['LIST_OF_USERS'] = 'List of users';
                $lang['LIST_OF_AGENTS'] = 'List of agents';
                
                $lang['NEW_USER'] = 'New user';
                $lang['NEW_AGENT'] = 'New agent';
                $lang['FNAME'] = 'Firstname';
                $lang['LNAME'] = 'Lastname';
                $lang['COMPANY'] = 'Company';
                $lang['NAME'] = 'Name';
                $lang['NAME'] = 'Name';
                $lang['EMAIL'] = 'Email';
                $lang['CHOOSE_PASSWORD_AGAIN'] = 'Choose password again';
                $lang['ADD_USER'] = 'Add User';
                $lang['ADD_NEW_USER'] = 'Add New User';

                $lang['ADD_AGENT'] = 'Add Agent';
                $lang['ADD_CUSTOMER'] = 'Add Customer';
                $lang['ADD_NEW_AGENT'] = 'Add New Agent';
                $lang['ADD_NEW_CUSTOMER'] = 'Add New Customer';
                $lang['AGENTID'] = 'Agent ID';
                $lang['CUSTOMERID'] = 'CUSTOMER ID';
                $lang['OWNER'] = 'Owner';
                $lang['TLF'] = 'Tlf';
                
                $lang['ACTION'] = 'ACTION';
                $lang['LAST_LOGIN'] = 'LAST LOGIN';
                $lang['JOINED'] = 'Joined';
                $lang['SEARCH'] = 'Search';
                $lang['GO'] = 'Go';
                $lang['SET_VALUTA'] = 'Set Valuta';
                $lang['USERS'] = 'Users';
                $lang['AGENTS'] = 'Agents';
                $lang['SETTINGS'] = 'Settings';
                $lang['SESSIONTIMEOUT'] = 'Session timeout';
                $lang['CREDIT_LIMIT'] = 'Credit limit';
                $lang['SITENAME'] = 'Site Name';
                
                
                // Page names
                $lang['P_SITES'] = 'Sites';
                $lang['P_BANKING'] = 'Banking Managing Menu';
                $lang['P_AGENT'] = 'Agent Managing Menu';
                $lang['P_USERS'] = 'List of login Users';
                $lang['P_CUSTOMERS'] = 'Customers';
                $lang['P_AGENTS'] = 'Manage Agents';
                $lang['P_AGENTSETTINGS'] = 'Settings';
                $lang['P_DEPOSIT'] = 'Agents with deposit';
                $lang['P_LOAN'] = 'Agents with loans';
                $lang['P_BALANCE'] = 'Balance overview';
                $lang['P_MANAGER'] = 'Manager accounts';
                
                
                // Transactions
                $lang['DATE']= 'Date';
								$lang['TYPE'] = 'Type';
								$lang['INFO'] = 'Info';
								$lang['REMARK'] = 'Remark';
								$lang['DEBIT'] = 'IN';
								$lang['CREDIT'] = 'OUT';
								$lang['BALANCE'] = 'Balance';
								$lang['ACCOUNT'] = 'Account';
								$lang['WITHDRAW'] = 'Withdraw';
								$lang['TRANSFER'] = 'Transfer';
								$lang['TRANSFERTO'] = 'Transfer to';
								$lang['LOAN'] = 'Loan/withdraw';
								$lang['DEPOSIT'] = 'Deposit';
								$lang['NEWDEPOSIT'] = 'New deposit';
								$lang['EDITDEPOSIT'] = 'Edit deposit';
								$lang['DELDEPOSIT'] = '<span style="color:FF0000;"> Delete deposit !</span>'; 
								$lang['UPDATEDEPOSIT'] = 'Update deposit';
								$lang['NEWLOAN'] = 'New loan/withdraw';
								$lang['EDITLOAN'] = 'Edit loan/withdraw';
								$lang['DELLOAN'] = '<span style="color:FF0000;"> Delete loan/withdraw !</span>';
								$lang['UPDATELOAN'] = 'Update loan/withdraw';
								$lang['UPDATETOPPAYMENT'] = 'Update Toppayment';
								$lang['TRANSFER'] = 'Transfer';
								$lang['NEWTRANSFER'] = 'New transfer';
								$lang['EDITTRANSFER'] = 'Edit transfer';
								$lang['UPDATETRANSFER'] = 'Update transfer';
								$lang['DELTRANSFER'] = 'Delete transfer';
								$lang['NEWDEBIT'] = 'New Debit';
								$lang['ADD_DEPOSIT'] = 'Add deposit';
								$lang['UPDATE_DEPOSIT'] = 'Update deposit';
								$lang['UPDATE_TOPPAYMENT'] = 'Update Toppayment';
								$lang['ADD_LOAN'] = 'Add Loan/withdraw';
								$lang['UPDATE_LOAN'] = 'Update Loan/withdraw';
								$lang['DEL_LOAN'] = 'Delete Loan/withdraw';
								$lang['DEL_TOP'] = 'Delete Toppayment';
								$lang['DELTOP'] = 'Delete Toppayment';
								$lang['ADD_TRANSFER'] = 'Transfer';
								$lang['UPDATE_TRANSFER'] = 'Update Transfer';
								$lang['BALANCE'] = 'Balance';
								$lang['MANAGER'] = 'Manager';
								$lang['MANAGERINFO'] = 'Manager information';
								
								
								
								$lang['AMOUNTOFDEPOSIT'] = 'Amount of deposit';
								$lang['AMOUNTOFLOAN'] = 'Amount of loan';
								$lang['AMOUNTOFTRANSFER'] = 'Amount of transfer';
								
								$lang['RATE'] = 'Rate';
								$lang['RATE0'] = 'Rate';
								$lang['RATE1'] = 'Dollar in';
								$lang['RATE2'] = 'Dollar out';
								$lang['RATE3'] = '$ balance';
								$lang['AMOUNT'] = 'Amount';
								$lang['RATEAMOUNT'] = 'Rate amount'; 
								$lang['RATE_PROFIT'] = 'Rate Profit';
								$lang['PCT_PROFIT'] = 'Procent Profit';
								$lang['RATE_BALANCE'] = 'Rate Balance';

								$lang['NEWTRANSFEROTHERS'] = 'Transfer to Agents';
								$lang['NEWTRANSFERMYACCOUNTS'] = 'Transfer to Own';
								$lang['NEWTRANSFEROWN'] = 'Transfer to Own';
								
								$lang['FROM'] = 'From';
								$lang['RO'] = 'To';
								$lang['CREATED'] = 'Created';
								$lang['ACCOUNTNR'] = 'Account nr.';
								$lang['CREDITLIMIT'] = 'Credit limit';
								$lang['AGENTIDTO'] = 'Transfer to';
								
								$lang['NEWAGENTPAY'] = 'Agent Payment';
								$lang['NEWTOPPAY'] = 'Top Payment';
								$lang['TOPPAYMENT'] = 'Top Payment';
								$lang['PAYNOW'] = 'Pay now';
								// $lang['RO'] = 'To';
								$lang['PROCENT'] = 'Procent';
								$lang['PROFITPROCENT'] = 'Profit procent';
								$lang['RATEPROFIT'] = 'Rate profit';
								
								$lang['SHOW_MANAGER'] = 'Show manager';
								$lang['SHOW_AGENTS'] = 'Show agents';
								$lang['SHOW_CUSTOMERS'] = 'Show customers';
								$lang['SHOW_USERS'] = 'Show users';
								$lang['SHOW_SETTINGS'] = 'Show settings';
								$lang['SHOW_BALANCE'] = 'Show balance';
																
								
								$lang['AC_MANAGER_NEW'] = 'Create new manager';
								$lang['AC_MANAGER_EDIT'] = 'Edit manager';
								$lang['AC_MANAGER_DEL'] = 'Delete manager';
								$lang['AC_MANAGER_DEPOSIT_ADD'] = 'Add deposit to manager';
								$lang['AC_MANAGER_DEPOSIT_EDIT'] = 'Edit manager deposit';
								$lang['AC_MANAGER_DEPOSIT_DEL'] = 'Delete manager deposit';
								$lang['AC_MANAGER_LOAN_ADD'] = 'Add loan to manager';
								$lang['AC_MANAGER_LOAN_EDIT'] = 'Edit manager loan';
								$lang['AC_MANAGER_LOAN_DEL'] = 'Delete manager loan';
								$lang['AC_MANAGER_TRANSFER_ADD'] = 'Transfer from manager';
								$lang['AC_MANAGER_TRANSFER_EDIT'] = 'Edit transfer in manager';
								$lang['AC_MANAGER_TRANSFER_DEL'] = 'Delete transfer in manager';
								$lang['AC_MANAGER_TOP_ADD'] = 'Add top payment manager ';
								$lang['AC_MANAGER_TOP_EDIT'] = 'Edit top payment in manager';
								$lang['AC_MANAGER_TOP_DEL'] = 'Delete top payment in manager';


								$lang['AC_AGENTS_NEW'] = 'Create new agent';
								$lang['AC_AGENTS_EDIT'] = 'Edit agent';
								$lang['AC_AGENTS_DEL'] = 'Delete agent';
								$lang['AC_AGENTS_DEPOSIT_ADD'] = 'Add deposit to agent';
								$lang['AC_AGENTS_DEPOSIT_EDIT'] = 'Edit agent deposit';
								$lang['AC_AGENTS_DEPOSIT_DEL'] = 'Delete agent deposit';
								$lang['AC_AGENTS_LOAN_ADD'] = 'Add loan to agent';
								$lang['AC_AGENTS_LOAN_EDIT'] = 'Edit agent loan';
								$lang['AC_AGENTS_LOAN_DEL'] = 'Delete agent loan';
								$lang['AC_AGENTS_TRANSFER_ADD'] = 'Transfer from agent';
								$lang['AC_AGENTS_TRANSFER_EDIT'] = 'Edit transfer in agent';
								$lang['AC_AGENTS_TRANSFER_DEL'] = 'Delete transfer in agent';
								$lang['AC_AGENTS_TOP_ADD'] = 'Add top payment agent ';
								$lang['AC_AGENTS_TOP_EDIT'] = 'Edit top payment in agent';
								$lang['AC_AGENTS_TOP_DEL'] = 'Delete top payment in agent';
									
								$lang['AC_CUSTOMERS_NEW'] = 'Create new customer';
								$lang['AC_CUSTOMERS_EDIT'] = 'Edit customer';
								$lang['AC_CUSTOMERS_DEL'] = 'Delete customer';
								$lang['AC_CUSTOMERS_DEPOSIT_ADD'] = 'Add deposit to customer';
								$lang['AC_CUSTOMERS_DEPOSIT_EDIT'] = 'Edit customer deposit';
								$lang['AC_CUSTOMERS_DEPOSIT_DEL'] = 'Delete customer deposit';
								$lang['AC_CUSTOMERS_LOAN_ADD'] = 'Add loan to customer';
								$lang['AC_CUSTOMERS_LOAN_EDIT'] = 'Edit customer loan';
								$lang['AC_CUSTOMERS_LOAN_DEL'] = 'Delete customer loan';
								$lang['AC_CUSTOMERS_TRANSFER_ADD'] = 'Transfer from customer';
								$lang['AC_CUSTOMERS_TRANSFER_EDIT'] = 'Edit transfer in customer';
								$lang['AC_CUSTOMERS_TRANSFER_DEL'] = 'Delete transfer in customer';
								$lang['AC_CUSTOMERS_TOP_ADD'] = 'Add top payment customer ';
								$lang['AC_CUSTOMERS_TOP_EDIT'] = 'Edit top payment in customer';
								$lang['AC_CUSTOMERS_TOP_DEL'] = 'Delete top payment in customer';
								
								$lang['AC_USERS_NEW'] = 'Create new user';
								$lang['AC_USERS_EDIT'] = 'Edit user';
								$lang['AC_USERS_DEL'] = 'Delete user';

                return $lang;
                break;


        }
    }
}

?>