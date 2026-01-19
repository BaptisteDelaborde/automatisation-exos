import { setActivePinia, createPinia } from 'pinia'
import { describe, it, beforeEach, expect } from 'vitest'
import { useCounterStore } from '../counter'

describe('Counter Store', () => {
    beforeEach(() => {
        setActivePinia(createPinia())
    })

    it('increments', () => {
        const store = useCounterStore()
        expect(store.count).toBe(0)
        store.increment()
        expect(store.count).toBe(1)
    })

    it('decrements', () => {
        const store = useCounterStore()
        store.count = 5
        store.decrement()
        expect(store.count).toBe(4)
    })
})