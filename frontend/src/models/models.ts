// Interface para a tabela 'users'
export interface User {
    id: number;
    name: string;
    email: string;
    emailVerifiedAt: string | null; // Nullable timestamp
    password: string;
    rememberToken: string | null;  // Nullable string
    createdAt: string;            // ISO timestamp
    updatedAt: string;            // ISO timestamp
}
  
  // Interface para a tabela 'posts'
export interface Post {
    id: number;
    userId: number;           // Foreign key to users table
    title: string;
    description: string;
    value: string;
    vendorId: string;
    productId: string;
    latitude: number;         // Decimal(10, 8)
    longitude: number;        // Decimal(11, 8)
    createdAt: string;        // ISO timestamp
    updatedAt: string;        // ISO timestamp
}
  