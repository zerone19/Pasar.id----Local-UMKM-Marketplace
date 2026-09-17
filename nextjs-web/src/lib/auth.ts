'use client';

// Simple client-side auth helpers using localStorage
export const getToken = (): string | null => {
  try {
    return typeof window !== 'undefined' ? localStorage.getItem('token') : null;
  } catch {
    return null;
  }
};

export const getUser = (): any | null => {
  try {
    if (typeof window === 'undefined') return null;
    const userJson = localStorage.getItem('user');
    return userJson ? JSON.parse(userJson) : null;
  } catch {
    return null;
  }
};

export const getUserRole = (): string | null => {
  const user = getUser();
  return user?.role || null;
};

export const setToken = (token: string): void => {
  if (typeof window !== 'undefined') {
    localStorage.setItem('token', token);
  }
};

export const setUser = (user: any): void => {
  if (typeof window !== 'undefined') {
    localStorage.setItem('user', JSON.stringify(user));
  }
};

export const clearToken = (): void => {
  if (typeof window !== 'undefined') {
    localStorage.removeItem('token');
    localStorage.removeItem('user');
  }
};
