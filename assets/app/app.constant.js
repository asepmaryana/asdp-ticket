angular.module('app.constant', [])
.constant('EVENTS', {
	notAuthenticated: 'auth-not-authenticated',
	notAuthorized: 'auth-not-authorized',
	sessionTimedout: 'session-time-out',
	internalError: 'internal-error',
	profileChanged: 'profile-changed',
	dashboardDisabled: 'dashboard-disabled'
})
.constant('USER_ROLES', {
	SAD: '1',
	ADM: '2',
	SPV: '3',
	KEU: '4',
	KLA: '5',
	KLT: '6',
	TGT: '7'
})
;