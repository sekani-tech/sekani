UPDATE acc_gl_account, trial_balance SET acc_gl_account.organization_running_balance_derived = trial_balance.closing_balance WHERE acc_gl_account.int_id = trial_balance.int_id AND acc_gl_account.gl_code = trial_balance.gl_code




SELECT branch.name, trial_balance.gl_code,trial_balance.name,trial_balance.opening_balance,trial_balance.debit,trial_balance.credit,trial_balance.closing_balance FROM trial_balance INNER JOIN branch ON trial_balance.office = branch.id WHERE trial_balance.int_id = 13