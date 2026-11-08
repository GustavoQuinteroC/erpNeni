import { defineConfig } from '@playwright/test';

export default defineConfig({
  testDir: 'e2e',
  timeout: 120_000,
  reporter: [['list']],
  use: { baseURL: 'http://127.0.0.1:8000/', screenshot: 'only-on-failure' },
  webServer: {
    command: 'php artisan serve --host=127.0.0.1 --port=8000',
    url: 'http://127.0.0.1:8000/up',
    reuseExistingServer: false,
  },
});
