<template>
  <div id="app">
	<div v-if="isLoggedIn" class="logged-in" key="loggedIn">
		<div class="flex bg-white fez123-border-bottom justify-between">
			<div class="flex">
				<div class="text-center" v-if="isAdmin">
					<button type="button" 
						class="no-outline fez123-border-right"
						@click="toggleSideNavbar">
						<span class="text-5xl"
							:class="{ 'fez-list': !hasSideNavbar, 'fez-close': hasSideNavbar }"></span>
					</button>
				</div>
				<div class="p-4 w-48 fez123-border-right">
					<router-link to="/" class="nav-logo no-underline primary-text">QMS</router-link>
				</div>
				<div class="p-4 pl-4">
					{{ $route.meta.title }}
				</div>
			</div>
			<div class="flex-initial">
				<div class="flex flex-row">
					<div class="mr-3" v-if="isLoggedIn && $route.meta.requireAuth">
						<Dropdown :actions="accountActions"
						@action-click="accountActionClicked($event)" 
						icon-size="5" 
						icon="fez-user"
						custom-class=""/>
					</div>
				</div>
			</div>
		</div>
		<div class="flex main-content">
			<div class="flex-none w-12 h-full bg-white pt-10 fez123-border-right side-navbar"
				key="mainnav"
				v-if="hasSideNavbar && isAdmin" style="animation-duration: .3s">
				<div class="flex-column">
					<div v-for="(link, index) in navLinks"
					:key="index">
						<router-link :title="link.title" 
						class="text-5xl no-underline primary-text relative" 
						:to="link.link" 
						v-tippy="{ placement: 'right', arrow: true }"
						v-if="link.link"
						@click.native="hideSubnavLinks">
							<span :class="link.icon" 
							class="align-middle"></span>
						</router-link>
						<div :title="link.title" 
							class="text-5xl no-underline primary-text cursor-pointer relative"
							:class="{ 'subnav-collapsed': (link.subnav && link.subnav == subnavLinks), 'router-link-exact-active': $route.name == link.name }" 
							:to="link.link" 
							v-tippy="{ placement: 'right', arrow: true }"
							v-if="!link.link"
							@click="showSubnavLinksOf(link)">
							<span :class="link.icon" 
							class="align-middle"></span>
						</div>
					</div>
				</div>
			</div>
			<div class="flex-none h-full w-48 bg-white pt-6 fez123-border-right side-subnavbar" 
			key="subnav"
			v-if="subnavLinks && hasSideNavbar && isAdmin">
				<div class="subnav-section mb-3 fez123-border-bottom pb-2"
					v-for="(subnavSection, sectionIndex) in subnavLinks"
					:key="sectionIndex">
					<span class="inline-block px-3 text-sm text-grey py-1">
						{{ sectionIndex }}
					</span>
					<router-link v-for="(link, index) in subnavSection"
						:to="link.link"
						class="no-underline primary-text block relative text-sm"
						:key="index">
						<span :class="link.icon" 
							class="text-4xl align-middle"></span>
						<span class="align-middle">
							{{ link.title }}
						</span>
					</router-link>
				</div>
			</div>
			<router-view/>
		</div>
	</div>
	<div v-else class="auth" key="auth">
		<router-view/>
	</div>
	<FullLoader v-if="isFullLoading"/>
  </div>
</template>

<script>
import FullLoader from '@/components/FullLoader.vue'
import Dropdown from '@/components/Base/Dropdown.vue'
import { mapGetters } from 'vuex'

export default {
	created(){
		let navLink = window._.find(this.navLinks, { name: this.$route.name })
		if(navLink){
			this.$store.dispatch('showSubnavLinksOf', navLink)
		}
	},
	components: {
		FullLoader,
		Dropdown
	},
	data() {
		return {
			hasSideNavbar: true,
			subnavActiveLink: null,
			accountActions: [
                {
                    title: 'Account Settings',
                    icon: 'fez-file'
                },
                {
                    title: 'Logout',
                    icon: 'fez-close'
                }
            ]
		};
	},
	methods: {
		toggleSideNavbar(){
			this.hasSideNavbar = !this.hasSideNavbar
		},
		showSubnavLinksOf(link){
			if(window._.isEqual(link.subnav, this.subnavLinks)) return this.hideSubnavLinks()
			this.subnavActiveLink = link
			this.$store.dispatch('showSubnavLinksOf', link)
		},
		hideSubnavLinks(){
			this.subnavActiveLink = null
			this.$store.commit('SUBNAV_LINKS', null)
		},
		accountActionClicked(action){
            switch(action.title){
                case 'Account Settings':
                    break;
				case 'Logout':
					this.$store.dispatch('logout')
						.then(() => {
							this.$router.replace('/login')
						})
                    break;
            }
		}
	},
	computed: {
		...mapGetters({
			isFullLoading: 'isFullLoading',
			navLinks: 'navLinks',
			subnavLinks: 'subnavLinks',
			isLoggedIn: 'isLoggedIn',
			isAdmin: 'isAdmin'
		})
	}
};
</script>


<style lang="scss">
@import "@/assets/scss/main.scss";
</style>
