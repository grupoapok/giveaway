import Vue from 'vue';

import {library} from '@fortawesome/fontawesome-svg-core';
import {FontAwesomeIcon} from '@fortawesome/vue-fontawesome';
import {fab} from '@fortawesome/free-brands-svg-icons';
import {faCheck, faCircleNotch, faComments, faSpinner} from '@fortawesome/free-solid-svg-icons';

library.add(fab, faCheck, faComments, faSpinner, faCircleNotch);

Vue.component('font-awesome-icon', FontAwesomeIcon);
