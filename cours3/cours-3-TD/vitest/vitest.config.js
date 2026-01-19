import { fileURLToPath } from 'node:url'
import { mergeConfig, defineConfig, configDefaults } from 'vitest/config'
import viteConfig from './vite.config'

export default mergeConfig(
  viteConfig,
  defineConfig({
    test: {
      environment: 'jsdom',
      exclude: [...configDefaults.exclude, 'e2e/*'],
      root: fileURLToPath(new URL('./', import.meta.url)),
      coverage: {
        provider: 'istanbul', // or 'v8'
        reporter: ['html'],
          exclude: [
              ...configDefaults.coverage.exclude || [],
              'src/components/icons/**\',\n' +
              'src/components/icons/**',
              'src/components/Welcome*.vue',
              'src/main.js'
          ]
      }
    }
  })
)
