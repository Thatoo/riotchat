/**
 * @copyright Copyright (c) 2021 Sorunome <mail@sornome.de>
 *
 * @author Sorunome <mail@sorunome.de>
 *
 * @license GNU AGPL version 3 or any later version
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 *
 */

import Vue from 'vue';
import ShareAdminSettings from "./components/settings/ShareAdminSettings";

document.addEventListener('DOMContentLoaded', main);

function main () {
    Vue.prototype.t = t;
    Vue.prototype.n = n;
    Vue.prototype.OC = window.OC;
    Vue.prototype.OCA = window.OCA;

    const View = Vue.extend(ShareAdminSettings);
    const view = new View();
    view.$mount('#riotchat-share-admin-settings');
}
