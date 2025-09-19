import React, { useState } from "react";


function Login() {
  const [email, setEmail] = useState(""); // estado para email
  const [senha, setSenha] = useState(""); // estado para senha

  return (
    <div>
      <h1>Página de Login</h1>
      <input
        type="email"
        placeholder="Digite seu e-mail"
        value={email}
        onChange={(e) => setEmail(e.target.value)}
      />
      <input
        type="password"
        placeholder="Digite sua senha"
        value={senha}
        onChange={(e) => setSenha(e.target.value)}
      />
    </div>
  );
}

export default Login;