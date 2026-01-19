import { describe, it, expect, beforeEach } from 'vitest'
import router from '@/router/index.js'

describe('Router', () => {
    beforeEach(async () => {
        // Réinitialise le router à la racine avant chaque test
        await router.push('/')
        await router.isReady()
    })

    it('navigates to home page by default', () => {
        expect(router.currentRoute.value.name).toBe('home')
    })

    it('navigates to demo page', async () => {
        await router.push('/demo')
        await router.isReady()
        expect(router.currentRoute.value.name).toBe('demo')
    })

    it('redirects to not found for unknown routes', async () => {
        await router.push('/cette-page-n-existe-pas')
        await router.isReady()
        // Le router n'a pas nommé la route 404, on vérifie donc le composant matché
        // Le composant importé est NotFoundView
        const matchedComponent = router.currentRoute.value.matched[0].components.default
        expect(matchedComponent.name).toBeUndefined() // NotFoundView n'a pas de nom explicite dans le fichier fourni, mais c'est bien la route matchée par regex
        expect(router.currentRoute.value.params.pathMatch).toBeDefined()
    })
})