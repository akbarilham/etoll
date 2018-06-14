<?php

namespace App\Constants;

interface ViewPaths {

	/* Dashboard*/
	const dashboard_page_heading = "Dashboard";
	const welcome_index = 'pages.welcome.index';

	/* Customer Care Dashboard*/
	const customer_care_dashboard_page_heading = "Customer Care Dashboard";
	const customer_care_dashboard_index = 'pages.customercare.dashboard.index';

	/* Master */
	/*- Tol Plaza -*/
	const master_tollplaza_page_heading = "Toll Plaza";
	const master_tollplaza_page_subheading = "Master Toll Plaza";
	const master_tollplaza_index = 'pages.master.toll_plaza.index';
	const master_tollplaza_list = 'pages.master.toll_plaza.list.body';
	const master_tollplaza_new = 'pages.master.toll_plaza.new';
	const master_tollplaza_edit = 'pages.master.toll_plaza.edit';

	/*- Lane -*/
	const master_lane_page_heading = "Lane";
	const master_lane_page_subheading = "Master Lane";
	const master_lane_index = 'pages.master.lane.index';
	const master_lane_list = 'pages.master.lane.list.body';
	const master_lane_new = 'pages.master.lane.new';
	const master_lane_edit = 'pages.master.lane.edit';

	/*- Bank -*/
	const master_bank_page_heading = "Bank";
	const master_bank_page_subheading = "Master Bank";
	const master_bank_index = 'pages.master.bank.index';
	const master_bank_list = 'pages.master.bank.list.body';
	const master_bank_new = 'pages.master.bank.new';
	const master_bank_edit = 'pages.master.bank.edit';

	/*- Operator -*/
	const master_operator_page_heading = "Operator";
	const master_operator_page_subheading = "Master Operator";
	const master_operator_index = 'pages.master.operator.index';
	const master_operator_list = 'pages.master.operator.list.body';
	const master_operator_new = 'pages.master.operator.new';
	const master_operator_edit = 'pages.master.operator.edit';

	/* Reporting */
	const reporting_page_heading = "Reporting";
	const reporting_operational_index = 'pages.reporting.index_operational';
	const reporting_operational_v2_index = 'pages.reporting.index_operationalV2';
	const reporting_financial_index = 'pages.reporting.index_financial';
	const reporting_history_index = 'pages.reporting.index_history';
	const reporting_gate_index = 'pages.reporting.index_gate';

	/* Security */
	const security_user_page_heading = "User";
	const security_user_page_subheading = "Security User";
	const security_user_index = 'pages.security.user.index';
	const security_user_list = 'pages.security.user.list.body';
	const security_user_new = 'pages.security.user.new';
	const security_user_edit = 'pages.security.user.edit';
	const security_user_change_password = 'pages.security.user.change_password';

	/* Security User Role */
	const security_user_role_page_heading = "User Role";
	const security_user_role_page_subheading = "Security User Role";
	const security_user_role_index = 'pages.security.userrole.index';
	const security_user_role_list = 'pages.security.userrole.list.body';
	const security_user_role_new = 'pages.security.userrole.new';
	const security_user_role_edit = 'pages.security.userrole.edit';

	const security_user_privilege_page_heading = "User";
	const security_user_privilege_page_subheading = "Security User";
	const security_user_privilege_index = 'pages.security.user_privilege.index';
	const security_user_privilege_list = 'pages.security.user_privilege.list.body';
	const security_user_privilege_new = 'pages.security.user_privilege.new';
	const security_user_privilege_edit = 'pages.security.user_privilege.edit';

	/* Security Menu*/
	const security_user_menu_page_heading = "Menu";
	const security_user_menu_page_subheading = "Security Menu";
	const security_user_menu_index = 'pages.security.user_menu.index';
	const security_user_menu_list = 'pages.security.user_menu.list.body';
	const security_user_menu_new = 'pages.security.user_menu.new';
	const security_user_menu_edit = 'pages.security.user_menu.edit';

	/*- Customer Care -*/
	const costumer_care_page_heading = "Customer Care Page";
	const costumer_care_page_subheading = "Customer Care";
	const costumer_care_index = 'pages.customercare.viewList.index';
	const costumer_care_list = 'pages.customercare.viewList.list.body';
	const costumer_care_new = 'pages.customercare.viewList.new';
	const costumer_care_edit = 'pages.customercare.viewList.edit';
	const customer_care_form_email = 'pages.customercare.viewList.email';

	/*- Customer Care Check-*/
	const costumer_care_check_page_heading = "Customer Care Check Page";
	const costumer_care_check_page_subheading = "Customer Care Check";
	const costumer_care_check_index = 'pages.customercare.checkHandler.index';
	const costumer_care_check_list = 'pages.customercare.checkHandler.list.body';
	const costumer_care_check_view = 'pages.customercare.checkHandler.view';

	/*- Transaction -*/
	const master_transaction_page_heading = "Transactions";
	const master_transaction_page_subheading = "Master Transactions";
	const master_transaction_index = 'pages.master.transaction.index';
	const master_transaction_list = 'pages.master.transaction.list.body';
	const master_transaction_new = 'pages.master.transaction.new';
	const master_transaction_edit = 'pages.master.transaction.edit';

	/* Transaction Rerate */
	const transaction_rerate_page_heading = " Transaction Rerate";
	const transaction_rerate_page_subheading = "Rerate";
	const transaction_rerate_index = 'pages.transaction.rerate.index';

	/*- Transaction Settlement -*/
	const transaction_settlement_page_heading = "Transaction Settlement";
	const transaction_settlement_page_subheading = "Transaction Settlement";
	const transaction_settlement_index = 'pages.transaction.settlement.index';
	const transaction_settlement_list = 'pages.transaction.settlement.list.body';
	const transaction_settlement_new = 'pages.transaction.settlement.new';
	const transaction_settlement_edit = 'pages.transaction.settlement.edit';

	/*- Balance History -*/
	const transaction_balance_history_page_heading = "Balance History";
	const transaction_balance_history_page_subheading = "Balance History";
	const transaction_balance_history_index = 'pages.transaction.balance_history.index';
	const transaction_balance_history_list = 'pages.transaction.balance_history.list.body';
	const transaction_balance_history_new = 'pages.transaction.balance_history.new';
	const transaction_balance_history_edit = 'pages.transaction.balance_history.edit';
}
?>