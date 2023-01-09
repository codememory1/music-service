interface AlertInterface {
  id: string;
  title: string;
  message: string;
  status: string;
  autoDeleteTime?: number;
}

export default AlertInterface;
