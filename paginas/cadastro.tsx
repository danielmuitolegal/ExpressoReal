export interface UsuarioCadastro {
  nome: string;
  email: string;
  senha: string;
}
export interface UsuarioLogin {
  email: string;
  senha: string;
}
export interface RespostaAPI {
  sucesso: boolean;
  mensagem?: string;
  
}

import React from 'react';
import ReactDOM from 'react-dom/client';
import App from './App';
import 'bootstrap/dist/css/bootstrap.min.css';

import React from 'react';
import './cadastro.css';