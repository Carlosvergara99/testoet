import Vehicle from './components/Vehicle/view.vue'
import Person from './components/Person/view.vue'
import Report from './components/Report/view.vue'
export default {
    mode: 'history',
    routes: [
        {
            path: '/',
            component: Vehicle,
            name: 'Vehicle',
        },
        {
            path: '/Person',
            component: Person,
            name: 'Person'
        },
        {
            path: '/Report',
            component: Report,
            name: 'Report'
        }
        
    ]
}