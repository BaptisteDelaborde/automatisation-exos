import { describe, it, expect } from 'vitest'
import { mount } from '@vue/test-utils'
import InputField from '../InputField.vue'

describe('InputField', () => {
    it('renders properly', () => {
        const wrapper = mount(InputField)
        expect(wrapper.text()).toContain('Text:')
    })

    it('updates text when input value changes', async () => {
        const wrapper = mount(InputField)
        const input = wrapper.find('input')

        // Simule l'écriture dans l'input
        await input.setValue('Hello Vitest')

        // Vérifie que le texte affiché dans le span (v-model) est mis à jour
        expect(wrapper.text()).toContain('You entered: Hello Vitest')
    })
})