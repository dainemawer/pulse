import { StrictMode } from 'react'
import { createRoot } from 'react-dom/client'
import { Dashboard } from "@pulse/ui";

createRoot(document.getElementById('rum-dashboard')).render(
  <StrictMode>
    <Dashboard />
  </StrictMode>,
)
