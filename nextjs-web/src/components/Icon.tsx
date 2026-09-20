import type { SVGProps } from 'react';

type IconName =
  | 'add'
  | 'arrow_forward'
  | 'check'
  | 'close'
  | 'error'
  | 'image'
  | 'inventory_2'
  | 'location_on'
  | 'menu'
  | 'person'
  | 'remove'
  | 'search'
  | 'shopping_bag'
  | 'shopping_cart'
  | 'store'
  | 'storefront'
  | 'warehouse'
  | 'payment'
  | 'receipt_long'
  | 'local_shipping'
  | 'warning'
  | 'done';

const paths: Record<IconName, string> = {
  add: 'M12 5v14M5 12h14',
  arrow_forward: 'M5 12h14M13 6l6 6-6 6',
  check: 'M5 12l4 4L19 6',
  close: 'M6 6l12 12M18 6L6 18',
  error: 'M12 8v4M12 16h.01M10.3 3.7L2.8 17a2 2 0 001.75 3h14.9a2 2 0 001.75-3L13.7 3.7a2 2 0 00-3.4 0z',
  image: 'M4 5h16v14H4zM4 15l4-4 3 3 2-2 7 7M15.5 9h.01',
  inventory_2: 'M4 5h16v14H4zM8 9h8M8 13h5',
  location_on: 'M12 21s7-5.1 7-11a7 7 0 10-14 0c0 5.9 7 11 7 11zM12 12a2.5 2.5 0 100-5 2.5 2.5 0 000 5z',
  menu: 'M4 7h16M4 12h16M4 17h16',
  person: 'M20 21a8 8 0 00-16 0M12 13a4 4 0 100-8 4 4 0 000 8z',
  remove: 'M5 12h14',
  search: 'M11 19a8 8 0 100-16 8 8 0 000 16zM21 21l-4.35-4.35',
  shopping_bag: 'M6 8h12l1 12H5L6 8zM9 8a3 3 0 016 0',
  shopping_cart: 'M3 4h2l2 11h10l3-8H6M9 19h.01M17 19h.01',
  store: 'M4 10h16v10H4zM3 10l2-5h14l2 5M8 10v10M16 10v10',
  storefront: 'M3 10l2-5h14l2 5M4 10v10h16V10M8 20v-6h8v6',
  warehouse: 'M3 10l9-6 9 6v10H3zM7 13h3v3H7zM14 13h3v3h-3z',
  payment: 'M3 6h18v12H3zM3 10h18M7 15h4',
  receipt_long: 'M6 3h12v18l-3-2-3 2-3-2-3 2V3zM9 8h6M9 12h6',
  local_shipping: 'M3 6h11v10H3zM14 10h4l3 3v3h-7zM7 19a2 2 0 100-4 2 2 0 000 4zM17 19a2 2 0 100-4 2 2 0 000 4z',
  warning: 'M12 3l10 18H2L12 3zM12 9v4M12 17h.01',
  done: 'M5 12l4 4L19 6',
};

export default function Icon({ name, size = 20, strokeWidth = 1.8, ...props }: { name: IconName; size?: number; strokeWidth?: number } & Omit<SVGProps<SVGSVGElement>, 'name'>) {
  return (
    <svg
      width={size}
      height={size}
      viewBox="0 0 24 24"
      fill="none"
      stroke="currentColor"
      strokeWidth={strokeWidth}
      strokeLinecap="round"
      strokeLinejoin="round"
      aria-hidden="true"
      focusable="false"
      {...props}
    >
      <path d={paths[name]} />
    </svg>
  );
}
