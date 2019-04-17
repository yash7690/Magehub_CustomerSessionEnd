	This module clears frontend user session based on customer id(s).

	There are 2 possible ways to clear the session.

	1. Admin Panel Customer Grid
		In admin panel customer grid, under mass actions, we have added an action with label "Clear Customer Session", so it will clear all customer sessions which you will choose in grid.

	2. Console command
		a. php bin/magento mh:customersessionend
		b. php bin/magento mh:customersessionend 1 2 3

		option a will delete all sessions as we are not passing customer ids
		option b will delete those session that you will pass in argument as customer ids