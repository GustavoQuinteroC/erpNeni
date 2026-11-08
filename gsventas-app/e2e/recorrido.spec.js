import { test, expect } from '@playwright/test';

const PANTALLAS = [
  '/', 'clientes', 'clientes/create', 'clientes/1/edit', 'proveedores', 'proveedores/create', 'ventas', 'ventas/create',
  'ventas/1', 'usuarios', 'usuarios/create', 'usuarios/1/edit', 'productos', 'productos/create', 'productos/1/edit',
  'almacenes', 'almacenes/create', 'almacenes/1/edit', 'recepciones', 'recepciones/create', 'recepciones/1/edit',
  'movimientos', 'movimientos/1', 'inventarios?almacen_id=1', 'puntos_entregas', 'entregas', 'entregas/1/edit',
  'indexhoy', 'indexmanana', 'comisionesVendedor', 'comisionesRepartidor', 'generador_rutas', 'perfil',
];
const ANCHOS = [390, 768, 1366];

// Los mosaicos del mapa vienen de un servidor externo; si alguno tarda no es un error de la app.
const ignorar = (texto) => /tile\.openstreetmap\.org/.test(texto);

async function entrar(page) {
  await page.goto('login');
  await expect(page.getByText('Demo de solo lectura')).toBeVisible();
  await page.locator('input[name="email"]').fill('demo@erpneni.test');
  await page.locator('input[name="password"]').fill('demo-erp-neni');
  await page.locator('form button[type="submit"]').click();
  await expect(page).toHaveURL(/127\.0\.0\.1:8000\/$/);
}

function vigilar(page) {
  const errores = [];
  page.on('pageerror', (e) => errores.push(`pageerror: ${e.message}`));
  page.on('console', (m) => { if (m.type() === 'error' && !ignorar(m.text())) errores.push(`console: ${m.text()}`); });
  page.on('response', (r) => { if (r.status() >= 400 && !ignorar(r.url())) errores.push(`HTTP ${r.status()}: ${r.url()}`); });
  return errores;
}

for (const ancho of ANCHOS) {
  test(`cada pantalla carga sin errores ni desborde a ${ancho} px`, async ({ page }, info) => {
    await page.setViewportSize({ width: ancho, height: 900 });
    const errores = vigilar(page);
    await entrar(page);

    for (const ruta of PANTALLAS) {
      await page.goto(ruta, { waitUntil: 'networkidle' });
      await expect(page.locator('main.app-main')).toBeVisible();
      const desborde = await page.evaluate(() => document.documentElement.scrollWidth - window.innerWidth);
      expect.soft(desborde, `${ruta} se desborda ${desborde}px a ${ancho}px`).toBeLessThanOrEqual(1);
      await page.screenshot({ path: info.outputPath(`${ancho}-${ruta.replace(/[^a-z0-9]+/gi, '_') || 'tablero'}.png`), fullPage: true });
    }

    expect(errores, errores.join('\n')).toEqual([]);
  });
}

test('las tablas cargan datos y la columna de Acciones queda fija', async ({ page }) => {
  const errores = vigilar(page);
  await entrar(page);
  await page.goto('ventas', { waitUntil: 'networkidle' });
  await expect(page.locator('#table1 tbody tr').first()).toBeVisible();
  await expect(page.locator('td.dtfc-fixed-end').first()).toBeVisible();
  expect(errores, errores.join('\n')).toEqual([]);
});

test('el buscador de clientes sugiere y llena los datos', async ({ page }) => {
  const errores = vigilar(page);
  await entrar(page);
  await page.goto('ventas/create', { waitUntil: 'networkidle' });
  await page.locator('#nombre_cliente').pressSequentially('Ana', { delay: 50 });
  const sugerencia = page.locator('.erp-sugerencias.show .dropdown-item').first();
  await expect(sugerencia).toBeVisible();
  await sugerencia.click();
  await expect(page.locator('#nombre_cliente')).toHaveValue('Ana Sofía Méndez');
  await expect(page.locator('#idsocio')).not.toHaveValue('');
  await expect(page.locator('#telefono')).not.toHaveValue('');
  expect(errores, errores.join('\n')).toEqual([]);
});

test('la demo no puede guardar y lo avisa', async ({ page }) => {
  await entrar(page);
  await page.goto('productos/create', { waitUntil: 'networkidle' });
  await page.locator('input[name="catalogo"]').fill('PRUEBA-01');
  await page.locator('input[name="precio"]').fill('100');
  await page.locator('input[name="costo"]').fill('50');
  await page.locator('.card form button[type="submit"]').first().click();
  await expect(page.getByText('La cuenta demo es de solo lectura.')).toBeVisible();
});

test('el tema oscuro se aplica y se recuerda', async ({ page }) => {
  await entrar(page);
  await page.evaluate(() => localStorage.setItem('lte-theme', 'dark'));
  await page.goto('/', { waitUntil: 'networkidle' });
  await expect(page.locator('html')).toHaveAttribute('data-bs-theme', 'dark');
  await expect(page.locator('#graficaMeses .apexcharts-canvas')).toBeVisible();
});
