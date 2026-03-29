import { Routes, Route } from "react-router-dom";

// ===== Importer les pages ici =====
// import Login from "@pages/Login";
// import Dashboard from "@pages/Dashboard";
// import NotFound from "@pages/NotFound";

// ===== Importer les layouts ici =====
// import { Layout } from "@components/layouts";

const AppRoutes = () => {
  return (
    <Routes>
      {/* Route publique */}
      {/* <Route path="/login" element={<Login />} /> */}

      {/* Routes protégées avec layout */}
      {/* <Route element={<Layout />}> */}
      {/*   <Route path="/" element={<Dashboard />} /> */}
      {/* </Route> */}

      {/* 404 */}
      {/* <Route path="*" element={<NotFound />} /> */}

      {/* Route par défaut temporaire */}
      <Route path="/" element={<div>Frontoffice</div>} />
    </Routes>
  );
};

export default AppRoutes;
