import React, { useState } from "react";

function Login() {
  const [email, setEmail] = useState("");
  const [senha, setSenha] = useState("");

  return (
    <div className="container-fluid d-flex justify-content-center align-items-center" style={{ height: "100vh", width: "100vw" }}>
      <div className="p-4 bg-light rounded">
        <h1 className="text-center text-dark">Login</h1>
        <input
          type="text"
          className="form-control"
          placeholder="Digite seu e-mail"
          value={email}
          onChange={(e) => setEmail(e.target.value)}
        />
        <input
          type="password"
          className="form-control"
          placeholder="Digite sua senha"
          value={senha}
          onChange={(e) => setSenha(e.target.value)}
        />
        <button className="btn btn-primary w-100">Entrar</button>
      </div>
      
    </div>
  );
}

export default Login;