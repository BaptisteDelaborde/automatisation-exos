import { describe, it, expect, vi } from 'vitest'
import { mount } from '@vue/test-utils'
import { createTestingPinia } from '@pinia/testing'
import Counter from '../CounterComponent.vue'
import { useCounterStore } from '@/stores/counter'

function mountCounter(x = 0) {
    const wrapper = mount(Counter, {
        global: {
            plugins: [
                createTestingPinia({
                    createSpy: vi.fn,
                    initialState: {
                        counter: { count: x }
                    }
                })
            ]
        }
    })
    return wrapper
}

describe('Counter', () => {
    it('renders properly', () => {
        const wrapper = mountCounter(50)
        expect(wrapper.text()).toContain('Counter: 50')
    })

    describe('Clicks', () => {
        it('increments counter', async () => {
            const wrapper = mountCounter(0)
            const store = useCounterStore()

            // Sélectionne le bouton contenant "Increment"
            const button = wrapper.findAll('button').find(b => b.text() === 'Increment')
            await button.trigger('click')

            // Vérifie que la méthode increment du store a été appelée
            expect(store.increment).toHaveBeenCalledTimes(1)
        })

        it('decrements counter', async () => {
            const wrapper = mountCounter(0)
            const store = useCounterStore()

            const button = wrapper.findAll('button').find(b => b.text() === 'Decrement')
            await button.trigger('click')

            expect(store.decrement).toHaveBeenCalledTimes(1)
        })
    })
})