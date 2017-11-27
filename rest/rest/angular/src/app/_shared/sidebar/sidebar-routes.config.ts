interface RouteInfo {
    route: string;
    title: string;
    icon: string;
    class: string;
}

export const ROUTES: RouteInfo[] = [

    { route: 'panel', title: 'Dashboard',  icon: 'dashboard', class: 'active' },
    { route: 'panel.products', title: 'Products',  icon:'store', class: '' },
    { route: 'panel.network', title: 'Network',  icon:'people', class: '' },
    { route: 'panel.earnings', title: 'Earnings',  icon:'attach_money', class: '' },
    { route: 'panel.trainings', title: 'Trainings',  icon:'school', class: '' },
    // { route: 'upgrade', title: 'Upgrade to PRO',  icon:'unarchive', class: 'active-pro' },
];
